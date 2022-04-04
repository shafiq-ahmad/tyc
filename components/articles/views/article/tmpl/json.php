<?php
defined('_MEXEC') or die ('Restricted Access');
//header("Content-Type: application/json; charset=UTF-8");
//header('Cache-Control: no-cache, must-revalidate');
//header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');


if(isset($this->row)){
	//print_r( $this->row);
	echo json_encode($this->row);
}
exit;
