<?php
defined('_MEXEC') or die ('Restricted Access');


class Mail extends Mobject{
	private $_site_name = '';
	private $_host = '';
	private $_port = 25;
	private $_username = '';
	private $_password = '';
	private $_from = '';
	private $_from_name = '';
	private $_to = '';
	
	public function __construct(){}
	
	public function send($data, $force_mail=null, $force_sms=null){ // $data contains message data eg. (user_id, subject, body)
		$content= "\nUser ID: " . $data['user_id'] . "\nSubject: " . $data['subject'] . "\nBody: " . $data['body'];
		setLog('mail sent:'. $content);
		return true;
	}
	
}

