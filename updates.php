com: lists
	view:countries.default.php
	view:countries.json.php
	view:country.json.php

com:lists
	view:cities.default.php
	view:cities.json.php
	view:city.json.php
	model:city
	
	ALTER TABLE `vehicles` CHANGE `visibility` `visibility` TINYINT(1) NOT NULL DEFAULT '4' COMMENT '1=true, 2=false, 3=admin approval, 4=draft';
	ALTER TABLE `vehicles` ADD `admin_remarks` TEXT NULL DEFAULT NULL AFTER `image_id`;
	ALTER TABLE `vehicles` ADD `deleted` TINYINT(1) NOT NULL DEFAULT '0' AFTER `admin_remarks`;
	
	

	










