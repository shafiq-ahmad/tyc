<?php
defined('_MEXEC') or die ('Restricted Access');
header("Content-Type: application/json; charset=UTF-8");
$city = $this->getVar('city',null,'get');
$port = $this->getVar('port',null,'get');
$v_type = $this->getVar('v_type',null,'get');

$this->ports = $m_shipping->getPortCity($city,$port,$v_type);
//echo json_encode($this->row);
//die();
