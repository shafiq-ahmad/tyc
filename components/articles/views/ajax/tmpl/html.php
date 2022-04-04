<?php
/**
Package: Point of sale
version: 1.0.0
URI: https://webapplics.com/apps/pos/1.0.0/docs
Author: Shafique Ahmad
Author URI: http://webapplics.com/
Description: 
copyright  Copyright (C) 2005 - 2014 Open Source Matters, Inc. All rights reserved.
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

*/


defined('_MEXEC') or die ('Restricted Access');

global $com,$view,$task;
//header("Content-Type: application/json; charset=UTF-8");
//echo $_POST['filter_text'];
//echo $id;exit;
//print_r($_POST);exit;
if ($_GET['part']=='itemByID'){
	$row = getDataByID($_POST['filter_text']);
	//print_r($row);
	echo json_encode($row);
}
if(isset($id)){
//print_r($_POST);exit;
if($_POST && $id!==0 && $task=="edit"){
	setData($_POST);
}elseif($task=="new"){
	createData($_POST);
}

//print_r($row);exit;

/*	
$cats = getCategoriesHTML($row['category']);
echo '<SELECT name="category" id="category" class="category form-control dropdown-header">';
echo '<OPTION value="">Please select a value</OPTION>';
foreach ($cats as $cat){
	echo '<optgroup label="' . $cat['name'] . '">';
	foreach ($cat as $c){
		print_r($c);echo '<br/>';
	}
	echo '</optgroup>';
}
echo '</SELECT>';
*/
}
?>