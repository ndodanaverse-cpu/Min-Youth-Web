<?php
/**
 * Shared workflow action handler for gallery, resources and departments.
 * Call from each list page BEFORE output starts.
 *
 * Required variables (set by including page):
 *   $table   – DB table name (e.g. 'gallery_items')
 *   $idCol   – primary-key column (always 'id')
 *   $nameCol – the column that holds the human-readable title/name
 *   $fileCols– array of file-path columns to delete on 'delete' action
 *   $backUrl – redirect URL after action (e.g. 'gallery.php')
 */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;

verify_csrf();
$aid    = (int)($_POST['id'] ?? 0);
$action = $_POST['action'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM `$table` WHERE id = ?");
$stmt->execute([$aid]);
$aItem = $stmt->fetch();

if ($aItem) {
    $label = $aItem[$nameCol] ?? 'item';

    switch ($action) {
        case 'submit':
            if ((int)$aItem['author_id'] === (int)$user['id']
                && in_array($aItem['status'], ['draft','rejected'], true)) {
                $pdo->prepare("UPDATE `$table` SET status='pending', updated_at=NOW() WHERE id=?")->execute([$aid]);
                log_activity($user, "submitted $table for editor review", $label);
                flash('success', 'Submitted for Editor review.');
            }
            break;

        case 'approve':
            if (can_approve($user) && $aItem['status'] === 'pending') {
                $pdo->prepare("UPDATE `$table` SET status='approved', reviewed_by=?, review_note=NULL, updated_at=NOW() WHERE id=?")
                    ->execute([$user['id'], $aid]);
                log_activity($user, "approved $table item", $label);
                flash('success', 'Approved — forwarded to Chief Editor for publication.');
            }
            break;

        case 'publish':
            if (can_publish($user) && in_array($aItem['status'], ['approved','pending'], true)) {
                $pdo->prepare("UPDATE `$table` SET status='published', reviewed_by=?, review_note=NULL, updated_at=NOW() WHERE id=?")
                    ->execute([$user['id'], $aid]);
                log_activity($user, "published $table item", $label);
                flash('success', 'Published to the live site.');
            }
            break;

        case 'reject':
            $canReject = (can_approve($user) && $aItem['status'] === 'pending')
                      || (is_chief_editor($user) && $aItem['status'] === 'approved');
            if ($canReject) {
                $note = trim($_POST['review_note'] ?? '');
                $pdo->prepare("UPDATE `$table` SET status='rejected', reviewed_by=?, review_note=?, updated_at=NOW() WHERE id=?")
                    ->execute([$user['id'], $note, $aid]);
                log_activity($user, "rejected $table item", $label);
                flash('success', 'Sent back with feedback.');
            }
            break;

        case 'unpublish':
            if (can_publish($user) && $aItem['status'] === 'published') {
                $pdo->prepare("UPDATE `$table` SET status='draft', updated_at=NOW() WHERE id=?")->execute([$aid]);
                log_activity($user, "unpublished $table item", $label);
                flash('success', 'Unpublished.');
            }
            break;

        case 'delete':
            if (can_delete($user)) {
                foreach ($fileCols as $col) {
                    if (!empty($aItem[$col])) @unlink(__DIR__ . '/../../' . $aItem[$col]);
                }
                $pdo->prepare("DELETE FROM `$table` WHERE id=?")->execute([$aid]);
                log_activity($user, "deleted $table item", $label);
                flash('success', 'Deleted.');
            }
            break;
    }
}
header('Location: ' . $backUrl . (isset($_GET['status']) ? '?status=' . urlencode($_GET['status']) : ''));
exit;
