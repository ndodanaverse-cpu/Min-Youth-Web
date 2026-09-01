<?php
/**
 * Database connection settings.
 *
 * Defaults below match XAMPP's out-of-the-box MySQL account (root with
 * no password) so the site works immediately after importing schema.sql
 * on a local XAMPP install.
 *
 * For a real/production server: create a dedicated, less-privileged
 * MySQL user for this site (see database/schema.sql for the
 * CREATE USER / GRANT statements) and update these four constants.
 */

define('DB_HOST', getenv('MINYOUTH_DB_HOST') ?: 'localhost');
define('DB_PORT', getenv('MINYOUTH_DB_PORT') ?: '3306');
define('DB_NAME', getenv('MINYOUTH_DB_NAME') ?: 'minyouth_cms');
define('DB_USER', getenv('MINYOUTH_DB_USER') ?: 'root');
define('DB_PASS', getenv('MINYOUTH_DB_PASS') ?: '');

/**
 * Returns a shared PDO connection. Throws on failure so calling code
 * (or PHP's error handler) surfaces connection problems immediately
 * instead of failing silently.
 */
function get_db(): PDO
{
    static $pdo = null;

    if ($pdo === null) {
        $dsn = 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]);
    }

    return $pdo;
}
