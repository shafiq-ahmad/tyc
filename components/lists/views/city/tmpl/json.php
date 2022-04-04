<?php
defined('_MEXEC') or die ('Restricted Access');
header("Content-Type: application/json; charset=UTF-8");
if($this->row){
echo json_encode($this->row);
}
//exit;
