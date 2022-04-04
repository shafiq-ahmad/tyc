<?php
defined('_MEXEC') or die ('Restricted Access');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


//$mail = new PHPMailer();
class Email extends PHPMailer{
	protected $from = '';
	protected $from_name = null;
	protected $reply = array();
	protected $cc = array();
	protected $bcc = array();
	
	public function __construct($ssl='tls'){
		//$this->SMTPDebug = 2;										// Enable verbose debug output
		$this->isSMTP();											// Set mailer to use SMTP
		$this->SMTPOptions = array(
			'ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true)
		);
		$this->Host	= SMTP_HOST;										// Specify main and backup SMTP servers
		$this->SMTPAuth   = true;									// Enable SMTP authentication
		$this->Username   = MAIL_LOGIN;									// SMTP username
		$this->Password   = MIAL_PASS;									// SMTP password
		$this->SMTPSecure = $ssl;									// Enable TLS encryption, `ssl` also accepted
		$this->Port	= SMTP_PORT;	
		
		parent::__construct(true);
	}
	
	public function sendMail($subject, $message, $to=array(), $attachments=array()){
		$obj = new Mobject();
		try {
			if(!$subject || !$message){
				$msg = "Subject or Message can not be empty";
				throw new Exception($msg);
			}
			if(!$to){
				$msg = "One or more Recipients required";
				throw new Exception($msg);
			}
			//Recipients
			if(!$this->from_name){$this->from_name=COMPANY;}
			if(!$this->from){
				$this->from=$this->Username;
			}
			$this->setFrom($this->from, $this->from_name);
			foreach($to as $t){
				//var_dump($t);exit;
				//echo $t[1];exit;
				$this->addAddress($t[0], $t[1]);	 // Add a recipient
			}
			if($this->reply){
				foreach($this->reply as $r){
					$this->addReplyTo($r[0], $r[1]);
				}
			}
			if($this->cc){
				foreach($this->cc as $c){
					$this->addCC($c[0], $c[1]);
				}
			}
			if($this->bcc){
				foreach($this->bcc as $b){
					$this->addBCC($b);
				}
			}
			if($attachments){
				foreach($attachments as $a){
					$this->addAttachment($a);
				}
			}
			// Content
			$this->isHTML(true);								  // Set email format to HTML
			$this->Subject = $subject;
			$this->Body	= $message;
			//$this->AltBody = 'This is the body in plain text for non-HTML mail clients';

			$this->send();
			$msg="Message sent";
			$obj->setMessage($msg);
			return $msg;
		} catch (Exception $e) {
			$msg="Message could not be sent. Mailer Error: {$this->ErrorInfo}";
			//echo $msg;
			$obj->setMessage($msg, 'danger');
		}


	}

}


/*
$message = "
<html>
<head>
<title>" . $subject . "</title>
</head>
<body>
<p>A student has been successfuly registered</p>
<table>
<tr>
<th>Full Name</th>
<th>Phone</th>
<th>Ref#</th>
</tr>
<tr>
<td>" . $title . "</td>
<td>" . $phone . "</td>
<td>" . $last_id . "</td>
</tr>
</table>
</body>
</html>
";

*/





