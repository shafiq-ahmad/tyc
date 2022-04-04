<?php
defined('_MEXEC') or die ('Restricted Access');

if(!class_exists('Restore_Database_MySQL')){
	import('core.database.restore');
}

define("BACKUP_DIR", SITE_PATH . DS . 'db_bak');
define("BACKUP_FILE", 'install.sql'); // Script will autodetect if backup file is gzipped based on .gz extension

/**
 * Instantiate Restore_Database_MySQL and perform backup
 */
// Report all errors
error_reporting(E_ALL);
// Set script max execution time
set_time_limit(900); // 15 minutes

if (php_sapi_name() != "cli") {
    echo '<div style="font-family: monospace;">';
}

$restoreDatabase = new Restore_Database_MySQL(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
$result = $restoreDatabase->restoreDb(BACKUP_DIR, BACKUP_FILE) ? 'OK' : 'KO';
$restoreDatabase->obfPrint("Restoration result: ".$result, 1);

if (php_sapi_name() != "cli") {
    echo '</div>';
}

