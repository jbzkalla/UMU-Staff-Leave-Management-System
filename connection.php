<?php
/**
 * APPLICATION NAME: Leon SmartLeave
 * APPLICATION: Leon SmartLeave
 * This is the main connector to the database. Without it, there won't be any
 * connection and some things will stop working/rendering
 */

/*
 * The name of the database that holds all our tabular data.
 */
define('DB_NAME', 'leave_manager');

/*
 * The username of the databse. Needed in addition to password for connection
 */
define("DB_USER", "groupone");

/*
 * Database password. Needed for connection to database(if set)
 */
define("DB_PASS", "12345678");

/*
 * Database host. This is localhost since we're developing locally
 */
define("DB_HOST", "localhost");

/*
 * Dynamic Base URL detection
 */
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script_name = $_SERVER['SCRIPT_NAME'];
$current_dir = dirname($script_name);
// Ensure trailing slash and handle root directory
$base_path = ($current_dir == DIRECTORY_SEPARATOR || $current_dir == '/') ? '/' : rtrim($current_dir, '/\\') . '/';
define("BASE_URL", $protocol . "://" . $host . $base_path);

/*
 * The main connection to the database is actually here.
 */

/*
 * @var $db_con will hold details to our connection
 */
$db_con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

/*
 * Character set to use for our connection. We'll choose utf-8 since it covers
 * more characters than ASCII.
 */
$db_con->set_charset("utf8");
?>
