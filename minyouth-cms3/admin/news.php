<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
$pdo = get_db();
$user = current_user();

/* ------------- workflow action handler ------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $id     = (int)($_POST['id'] ?? 0);
    $action = $_POST['action'] ?? '';
    $stmt   = $pdo->prepare('SELECT * FROM news WHERE id = ?');
    $stmt->execute([$id]);
    $item = $stmt->fetch();

    if ($item) {
        switch ($action) {
            // Sub editor: submit draft/rejected → pending (Editor queue)
            case 'submit':
                if ((int)$item['author_id'] === (int)$user['id']
                    && in_array($item['status'], ['draft','rejected'], true)) {
                    $pdo->prepare("UPDATE news SET status='pending', updated_at=NOW() WHERE id=?")->execute([$id]);
                    log_activity($user, 'submitted news for editor review', $item['title']);
                    flash('success', 'Submitted — an Editor will review it next.');
                }
                break;

            // Editor + Chief editor: approve pending → approved (Chief Editor queue)
            case 'approve':
                if (can_approve($user) && $item['status'] === 'pending') {
                    $pdo->prepare("UPDATE news SET status='approved', reviewed_by=?, review_note=NULL, updated_at=NOW() WHERE id=?")
                        ->execute([$user['id'], $id]);
                    log_activity($user, 'approved news', $item['title']);
                    flash('success', 'Approved — now waiting for the Chief Editor to publish.');
                }
                break;

            // Chief editor ONLY: publish approved (or pending) → live
            case 'publish':
                if (can_publish($user) && in_array($item['status'], ['approved','pending'], true)) {
                    $pdo->prepare("UPDATE news SET status='published', reviewed_by=?, review_note=NULL, published_at=COALESCE(published_at,NOW()), updated_at=NOW() WHERE id=?")
                        ->execute([$user['id'], $id]);
                    log_activity($user, 'published news', $item['title']);
                    flash('success', 'Published to the live site.');
                }
                break;

            // Editor rejects pending; Chief editor rejects pending or approved
            case 'reject':
                $canReject = (can_approve($user) && $item['status'] === 'pending')
                          || (is_chief_editor($user) && $item['status'] === 'approved');
                if ($canReject) {
                    $note = trim($_POST['review_note'] ?? '');
                    $pdo->prepare("UPDATE news SET status='rejected', reviewed_by=?, review_note=?, updated_at=NOW() WHERE id=?")
                        ->execute([$user['id'], $note, $id]);
                    log_activity($user, 'rejected news', $item['title']);
                    flash('success', 'Sent back to the author with feedback.');
                }
                break;

            // Chief editor only: take a published item offline
            case 'unpublish':
                if (can_publish($user) && $item['status'] === 'published') {
                    $pdo->prepare("UPDATE news SET status='draft', updated_at=NOW() WHERE id=?")->execute([$id]);
                    log_activity($user, 'unpublished news', $item['title']);
                    flash('success', 'Unpublished — moved back to drafts.');
                }
                break;

            // Chief editor only: permanent removal
            case 'delete':
                if (can_delete($user)) {
                    if ($item['image']) { @unlink(__DIR__ . '/../' . $item['image']); }
                    $pdo->prepare('DELETE FROM news WHERE id=?')->execute([$id]);
                    log_activity($user, 'deleted news', $item['title']);
                    flash('success', 'Article deleted.');
                }
                break;
        }
    }
    header('Location: news.php' . (isset($_GET['status']) ? '?status=' . urlencode($_GET['status']) : ''));
    exit;
}

/* ------------- build list ------------- */
$status = $_GET['status'] ?? 'all';
$validStatuses = ['all','draft','pending','approved','published','rejected'];
if (!in_array($status, $validStatuses, true)) $status = 'all';

$sql = "SELECT n.*, u.full_name AS author_name
        FROM news n JOIN users u ON u.id = n.author_id";
$params = [];
if ($status !== 'all') { $sql .= " WHERE n.status = ?"; $params[] = $status; }
$sql .= " ORDER BY n.updated_at DESC";
$stmt = $pdo->prepare($sql); $stmt->execute($params);
$items = $stmt->fetchAll();

$pageTitle = 'News & Events'; $activeNav = 'news';
require __DIR__ . '/includes/header.php';

/* ------------- workflow info banner ------------- */
if ($user['role'] === 'sub_editor'):
    $cnt = $pdo->prepare("SELECT COUNT(*) FROM news WHERE author_id=? AND status='pending'"); $cnt->execute([$user['id']]); $p = (int)$cnt->fetchColumn();
    $cnt2 = $pdo->prepare("SELECT COUNT(*) FROM news WHERE author_id=? AND status='rejected'"); $cnt2->execute([$user['id']]); $r = (int)$cnt2->fetchColumn();
    if ($p || $r): ?>
<div class="mb-5 flex flex-wrap gap-3">
  <?php if ($p): ?><div class="bg-secondary-container text-on-secondary-container text-sm rounded-lg px-4 py-2 flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">pending</span> <?= $p ?> article<?= $p>1?'s':'' ?> pending Editor review</div><?php endif; ?>
  <?php if ($r): ?><div class="bg-error-container text-on-error-container text-sm rounded-lg px-4 py-2 flex items-center gap-2"><span class="material-symbols-outlined text-[18px]">undo</span> <?= $r ?> article<?= $r>1?'s':'' ?> returned with feedback</div><?php endif; ?>
</div>
<?php endif; elseif ($user['role'] === 'editor'):
    $cnt = $pdo->query("SELECT COUNT(*) FROM news WHERE status='pending'")->fetchColumn();
    if ($cnt): ?>
<div class="mb-5 bg-secondary-container text-on-secondary-container text-sm rounded-lg px-4 py-2 flex items-center gap-2">
  <span class="material-symbols-outlined text-[18px]">rate_review</span>
  <?= $cnt ?> article<?= $cnt>1?'s':'' ?> waiting for your approval — approve to forward to Chief Editor.
</div>
<?php endif; elseif (is_chief_editor($user)):
    $cnt = $pdo->query("SELECT COUNT(*) FROM news WHERE status='approved'")->fetchColumn();
    if ($cnt): ?>
<div class="mb-5 bg-tertiary-container text-on-tertiary-container text-sm rounded-lg px-4 py-2 flex items-center gap-2">
  <span class="material-symbols-outlined text-[18px]">publish</span>
  <?= $cnt ?> article<?= $cnt>1?'s':'' ?> approved by an Editor and waiting for you to publish.
</div>
<?php endif; endif; ?>

<div class="flex items-center justify-between mb-4 flex-wrap gap-3">
  <div class="flex gap-2 flex-wrap">
    <?php foreach ($validStatuses as $s): ?>
      <a href="?status=<?= $s ?>" class="px-3 py-1.5 rounded-full text-sm border capitalize
        <?= $status===$s ? 'bg-primary text-on-primary border-primary' : 'border-outline-variant text-on-surface-variant hover:bg-surface-container-low' ?>">
        <?= $s ?>
      </a>
    <?php endforeach; ?>
  </div>
  <a href="news_form.php" class="bg-primary text-on-primary px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-1.5 hover:opacity-90">
    <span class="material-symbols-outlined text-[18px]">add</span> New article
  </a>
</div>

<div class="bg-white border border-outline-variant rounded-xl overflow-hidden">
  <table class="w-full text-sm">
    <thead class="bg-surface-container-low text-on-surface-variant text-left">
      <tr>
        <th class="px-4 py-3 font-medium">Title</th>
        <th class="px-4 py-3 font-medium">Author</th>
        <th class="px-4 py-3 font-medium">Status</th>
        <th class="px-4 py-3 font-medium">Next step</th>
        <th class="px-4 py-3 font-medium">Updated</th>
        <th class="px-4 py-3 font-medium text-right">Actions</th>
      </tr>
    </thead>
    <tbody class="divide-y divide-outline-variant">
      <?php if (!$items): ?>
        <tr><td colspan="6" class="px-4 py-10 text-center text-on-surface-variant">No articles here yet.</td></tr>
      <?php endif; ?>
      <?php foreach ($items as $item): ?>
        <tr class="hover:bg-surface-container-low/50">
          <td class="px-4 py-3 max-w-xs">
            <p class="font-medium truncate"><?= e($item['title']) ?></p>
            <?php if ($item['review_note']): ?>
              <p class="text-xs text-error mt-0.5 truncate">Feedback: <?= e($item['review_note']) ?></p>
            <?php endif; ?>
          </td>
          <td class="px-4 py-3 text-on-surface-variant"><?= e($item['author_name']) ?></td>
          <td class="px-4 py-3"><?= status_badge($item['status']) ?></td>
          <td class="px-4 py-3 text-xs text-on-surface-variant max-w-[140px]"><?= workflow_hint($item['status']) ?></td>
          <td class="px-4 py-3 text-on-surface-variant whitespace-nowrap"><?= format_date($item['updated_at']) ?></td>
          <td class="px-4 py-3">
            <div class="flex items-center justify-end gap-1 flex-wrap">

              <?php /* ---- Edit ---- */ if (can_edit_item($user, $item)): ?>
                <a href="news_form.php?id=<?= $item['id'] ?>" class="p-1.5 rounded hover:bg-surface-container-high" title="Edit"><span class="material-symbols-outlined text-[18px]">edit</span></a>
              <?php endif; ?>

              <?php /* ---- Preview (all roles) ---- */ ?>
              <a href="preview.php?type=news&id=<?= $item['id'] ?>" target="_blank" class="p-1.5 rounded hover:bg-surface-container-high" title="Preview"><span class="material-symbols-outlined text-[18px]">preview</span></a>

              <?php /* ---- Sub editor: submit ---- */
              if ($user['role'] === 'sub_editor'
                  && (int)$item['author_id'] === (int)$user['id']
                  && in_array($item['status'], ['draft','rejected'], true)): ?>
                <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $item['id'] ?>"><input type="hidden" name="action" value="submit">
                  <button class="p-1.5 rounded hover:bg-secondary-container text-on-secondary-container" title="Submit for Editor review"><span class="material-symbols-outlined text-[18px]">send</span></button>
                </form>
              <?php endif; ?>

              <?php /* ---- Editor: approve pending ---- */
              if (can_approve($user) && $item['status'] === 'pending'): ?>
                <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $item['id'] ?>"><input type="hidden" name="action" value="approve">
                  <button class="p-1.5 rounded hover:bg-tertiary-container text-on-tertiary-container" title="Approve — forward to Chief Editor"><span class="material-symbols-outlined text-[18px]">thumb_up</span></button>
                </form>
              <?php endif; ?>

              <?php /* ---- Chief editor: publish approved (or pending override) ---- */
              if (can_publish($user) && in_array($item['status'], ['approved','pending'], true)): ?>
                <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $item['id'] ?>"><input type="hidden" name="action" value="publish">
                  <button class="p-1.5 rounded hover:bg-primary-container text-primary" title="Publish to live site"><span class="material-symbols-outlined text-[18px]">rocket_launch</span></button>
                </form>
              <?php endif; ?>

              <?php /* ---- Reject: editor on pending, chief editor on pending/approved ---- */
              $canReject = (can_approve($user) && $item['status'] === 'pending')
                        || (is_chief_editor($user) && $item['status'] === 'approved');
              if ($canReject): ?>
                <button type="button"
                        onclick="document.getElementById('reject-news-<?= $item['id'] ?>').classList.toggle('hidden')"
                        class="p-1.5 rounded hover:bg-error-container text-error" title="Reject with feedback">
                  <span class="material-symbols-outlined text-[18px]">undo</span>
                </button>
              <?php endif; ?>

              <?php /* ---- Chief editor: unpublish ---- */
              if (can_publish($user) && $item['status'] === 'published'): ?>
                <form method="post"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $item['id'] ?>"><input type="hidden" name="action" value="unpublish">
                  <button class="p-1.5 rounded hover:bg-surface-container-high" title="Unpublish"><span class="material-symbols-outlined text-[18px]">visibility_off</span></button>
                </form>
              <?php endif; ?>

              <?php /* ---- Chief editor: delete ---- */
              if (can_delete($user)): ?>
                <form method="post" onsubmit="return confirm('Delete this article permanently?');"><?= csrf_field() ?><input type="hidden" name="id" value="<?= $item['id'] ?>"><input type="hidden" name="action" value="delete">
                  <button class="p-1.5 rounded hover:bg-error-container text-error" title="Delete"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                </form>
              <?php endif; ?>
            </div>

            <?php /* ---- Inline reject form ---- */ if ($canReject ?? false): ?>
              <form method="post" id="reject-news-<?= $item['id'] ?>" class="hidden mt-2 flex gap-2">
                <?= csrf_field() ?><input type="hidden" name="id" value="<?= $item['id'] ?>"><input type="hidden" name="action" value="reject">
                <input name="review_note" placeholder="Reason for rejection…" required
                       class="flex-1 text-xs border border-outline-variant rounded px-2 py-1 focus:ring-1 focus:ring-error outline-none">
                <button class="text-xs font-semibold text-error whitespace-nowrap">Send back</button>
              </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>
