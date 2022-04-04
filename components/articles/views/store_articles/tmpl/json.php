<?php
defined('_MEXEC') or die ('Restricted Access');
header("Content-Type: application/json; charset=UTF-8");
header('Cache-Control: max-age=3000, must-revalidate');
//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

echo json_encode($this->rows);
exit;


