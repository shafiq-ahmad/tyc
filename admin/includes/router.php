<?php
defined('_MEXEC') or die ('Restricted Access');
/*
.htaccess
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php/$1 [L]

*/



$uri = $_SERVER['REQUEST_URI'];
$uri = trim($uri,"/");
$uri=explode("/",$uri);
print_r($uri);exit;