<?php
defined('_MEXEC') or die ('Restricted Access');

if(isset($_SESSION['token'])){
	define('TOKEN', $_SESSION['token']);
}
define('URI', 'http://localhost/tyc/');
define('COMPANY', 'TyconTrader');
define('MAIL_LOGIN', 'tycontrader2019@gmail.com');
define('MIAL_PASS', 'Ali_jabari_2019');
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('MAIL_ADMIN', 'scmnst@yahoo.com');
define('LOGIN_SUCCESS_URI', '?com=users&view=profile');
