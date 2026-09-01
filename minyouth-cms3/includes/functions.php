<?php
/**
 * Shared helper functions used across the admin panel.
 */

require_once __DIR__ . '/../config/database.php';

/** Escape a string for safe HTML output. */
function e(?string $value): string
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

/** Turn a title into a URL-friendly, unique slug for the news table. */
function make_slug(string $title, int $ignoreId = 0): string
{
    $slug = strtolower(trim($title));
    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
    $slug = trim($slug, '-');
    if ($slug === '') {
        $slug = 'post';
    }

    $pdo = get_db();
    $base = $slug;
    $i = 1;
    while (true) {
        $stmt = $pdo->prepare('SELECT id FROM news WHERE slug = ? AND id != ?');
        $stmt->execute([$slug, $ignoreId]);
        if (!$stmt->fetch()) {
            break;
        }
        $slug = $base . '-' . (++$i);
    }

    return $slug;
}

/* ------------------------------------------------------------------ *
 * Flash messages (one-time banners shown after a redirect)
 * ------------------------------------------------------------------ */

function flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    if (empty($_SESSION['flash'])) {
        return null;
    }
    $f = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $f;
}

/* ------------------------------------------------------------------ *
 * CSRF protection for every POST form in /admin
 * ------------------------------------------------------------------ */

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
}

function verify_csrf(): void
{
    $token = $_POST['csrf_token'] ?? '';
    if (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        http_response_code(400);
        die('Security check failed. Please go back, refresh the page, and try again.');
    }
}

/* ------------------------------------------------------------------ *
 * File uploads
 * ------------------------------------------------------------------ */

/**
 * Handles a single <input type="file"> upload.
 *
 * @return string|null Relative path (e.g. "uploads/news/xxx.jpg") on success,
 *                      null if no file was submitted, throws on a real error.
 */
function handle_upload(string $fieldName, string $subfolder, array $allowedExt, int $maxSizeMB = 10): ?string
{
    if (empty($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return null;
    }

    $file = $_FILES[$fieldName];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Upload failed (error code ' . $file['error'] . ').');
    }

    if ($file['size'] > $maxSizeMB * 1024 * 1024) {
        throw new RuntimeException("File is too large. Maximum size is {$maxSizeMB}MB.");
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExt, true)) {
        throw new RuntimeException('File type .' . $ext . ' is not allowed. Allowed: ' . implode(', ', $allowedExt));
    }

    $destDir = __DIR__ . '/../uploads/' . $subfolder;
    if (!is_dir($destDir)) {
        mkdir($destDir, 0775, true);
    }

    $filename = bin2hex(random_bytes(8)) . '-' . time() . '.' . $ext;
    $destPath = $destDir . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destPath)) {
        throw new RuntimeException('Could not save the uploaded file. Check folder permissions on /uploads.');
    }

    return 'uploads/' . $subfolder . '/' . $filename;
}

/* ------------------------------------------------------------------ *
 * Permission rules — three-stage editorial workflow
 *
 *  sub_editor   draft → submit (pending)
 *  editor       pending → approve (approved) or reject (rejected)
 *  chief_editor approved → publish (published) or reject (rejected)
 *               ONLY chief_editor can publish to the live site
 * ------------------------------------------------------------------ */

function is_editor(array $user): bool
{
    return in_array($user['role'], ['editor', 'chief_editor'], true);
}

function is_chief_editor(array $user): bool
{
    return $user['role'] === 'chief_editor';
}

/** Editors AND chief editors can approve pending content. */
function can_approve(array $user): bool
{
    return is_editor($user);
}

/** ONLY the chief editor can publish content to the live site. */
function can_publish(array $user): bool
{
    return is_chief_editor($user);
}

/** ONLY the chief editor can delete content. */
function can_delete(array $user): bool
{
    return is_chief_editor($user);
}

/** ONLY the chief editor can manage user accounts. */
function can_manage_users(array $user): bool
{
    return is_chief_editor($user);
}

/**
 * Can this user open the edit form for this item?
 * - Chief editor / Editor: can edit any item at any status.
 * - Sub editor: can only edit their own items that are still in
 *   draft or rejected — once submitted or approved, they must wait.
 */
function can_edit_item(array $user, array $item): bool
{
    if (is_editor($user)) {
        return true;
    }
    return (int)$item['author_id'] === (int)$user['id']
        && in_array($item['status'], ['draft', 'rejected'], true);
}

/**
 * Compute the new status after a form save action, enforcing roles.
 * Falls back to 'draft' if the user tries an action they're not
 * permitted to perform (defence-in-depth on top of the UI).
 */
function resolve_save_status(string $action, array $user): string
{
    return match(true) {
        $action === 'publish' && can_publish($user)  => 'published',
        $action === 'approve' && can_approve($user)  => 'approved',
        $action === 'submit'                         => 'pending',
        default                                      => 'draft',
    };
}

/** Human-friendly role label. */
function role_label(string $role): string
{
    return match ($role) {
        'chief_editor' => 'Chief Editor',
        'editor'       => 'Editor',
        default        => 'Sub Editor',
    };
}

/** Tailwind classes for the role pill in the topbar. */
function role_badge_classes(string $role): string
{
    return match ($role) {
        'chief_editor' => 'bg-primary-container text-on-primary-container',
        'editor'       => 'bg-tertiary-container text-on-tertiary-container',
        default        => 'bg-secondary-container text-on-secondary-container',
    };
}

/** Coloured status pill shown in content list tables. */
function status_badge(string $status): string
{
    $map = [
        'draft'     => 'bg-surface-container-high text-on-surface-variant',
        'pending'   => 'bg-secondary-container text-on-secondary-container',
        'approved'  => 'bg-tertiary-container text-on-tertiary-container',
        'published' => 'bg-primary-container text-on-primary-container',
        'rejected'  => 'bg-error-container text-on-error-container',
    ];
    $cls = $map[$status] ?? 'bg-surface-container text-on-surface';
    return '<span class="inline-block px-sm py-[2px] rounded-full text-label-sm font-label-sm font-semibold capitalize ' . $cls . '">' . e($status) . '</span>';
}

/**
 * Next-step hint shown below content items so every role knows what
 * happens next.
 */
function workflow_hint(string $status): string
{
    return match ($status) {
        'draft'     => 'Sub Editor must submit for review.',
        'pending'   => 'Waiting for Editor to approve.',
        'approved'  => 'Waiting for Chief Editor to publish.',
        'published' => 'Live on the public site.',
        'rejected'  => 'Returned with feedback — Sub Editor must revise and resubmit.',
        default     => '',
    };
}

function log_activity(array $user, string $action, string $details = ''): void
{
    $pdo = get_db();
    $stmt = $pdo->prepare('INSERT INTO activity_log (user_id, action, details) VALUES (?, ?, ?)');
    $stmt->execute([$user['id'], $action, $details]);

    if (str_contains($action, 'translation') || preg_match(
        '/\b(created|updated|added|published|unpublished|deleted)\s+(news|gallery item|gallery_items|resource|resources|department|departments)\b/',
        $action
    )) {
        $exporter = __DIR__ . '/../static-export.php';
        $command = escapeshellarg(PHP_BINARY) . ' ' . escapeshellarg($exporter) . ' > NUL 2>&1';
        @pclose(@popen($command, 'r'));
    }
}

function format_date(?string $datetime): string
{
    if (!$datetime) {
        return '—';
    }
    return date('d M Y, H:i', strtotime($datetime));
}
