<?php
defined('_MEXEC') or die ('Restricted Access');
header("Content-Type: application/json; charset=UTF-8");

echo json_encode($this->row);exit;

