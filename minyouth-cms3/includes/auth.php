<?php
/**
 * Session bootstrap + authentication helpers.
 * Every protected admin page should start with:
 *     require_once __DIR__ . '/../includes/auth.php';
 *     require_login();
 */

if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
    session_start();
}

require_once __DIR__ . '/functions.php';

/** Returns the logged-in user array, or null if no one is logged in. */
function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

/** Redirects to the login page unless a user is logged in. */
function require_login(): void
{
    if (!current_user()) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'] ?? 'index.php';
        header('Location: login.php');
        exit;
    }
}

/**
 * Restricts a page to one or more roles.
 * Usage: require_role('editor');  or  require_role(['editor','sub_editor']);
 */
function require_role($roles): void
{
    require_login();
    $roles = is_array($roles) ? $roles : [$roles];
    if (!in_array(current_user()['role'], $roles, true)) {
        http_response_code(403);
        echo '<!doctype html><html><body style="font-family:sans-serif;text-align:center;padding:80px">'
           . '<h1 style="color:#ba1a1a">403 — Access denied</h1>'
           . '<p>Your account role does not have permission to view this page.</p>'
           . '<p><a href="index.php">&larr; Back to dashboard</a></p></body></html>';
        exit;
    }
}

/**
 * Attempts to log a user in. Returns true on success, false on bad
 * credentials or an inactive/disabled account.
 */
function attempt_login(string $username, string $password): bool
{
    $pdo = get_db();
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        return false;
    }

    if ($user['status'] !== 'active') {
        return false;
    }

    unset($user['password_hash']);
    $_SESSION['user'] = $user;

    $upd = $pdo->prepare('UPDATE users SET last_login = NOW() WHERE id = ?');
    $upd->execute([$user['id']]);

    log_activity($user, 'login', 'Signed in');

    return true;
}

function logout(): void
{
    if ($user = current_user()) {
        log_activity($user, 'logout', 'Signed out');
    }
    $_SESSION = [];
    session_destroy();
}
