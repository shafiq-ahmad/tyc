<?php
require_once "admin/inc/config.php";
require_once "inc/header.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
$msg="";
$mail = new PHPMailer(true);









if(isset($_POST['submit'])){
	// prepare and bind
	$stmt = $conn->prepare("INSERT INTO students (title,e_mail,phone) VALUES(?, ? ,?)");
	$title = $_POST['title'];
	$e_mail = $_POST['e_mail'];
	$phone = $_POST['phone'];
	$stmt->bind_param("sss", $title, $e_mail, $phone);

	// set parameters and execute
	$res = $stmt->execute();
	$data = $stmt->get_result();
	$last_id = $conn->insert_id;

	$subject = "Registration Successful";

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




try {
	//Server settings
	//$mail->SMTPDebug = 2;										// Enable verbose debug output
	$mail->isSMTP();											// Set mailer to use SMTP
	$mail->SMTPOptions = array(
	'ssl' => array(
	'verify_peer' => false,
	'verify_peer_name' => false,
	'allow_self_signed' => true
	));
	$mail->Host	= 'smtp.gmail.com';								// Specify main and backup SMTP servers
	$mail->SMTPAuth   = true;									// Enable SMTP authentication
	$mail->Username   = 'contest2k19@gmail.com';				// SMTP username
	$mail->Password   = 'Ajman2019.';							// SMTP password
	$mail->SMTPSecure = 'tls';									// Enable TLS encryption, `ssl` also accepted
	$mail->Port	= 587;											// TCP port to connect to

	//Recipients
	$mail->setFrom('contest2k19@gmail.com', 'SMAC 2020');
	$mail->addAddress(ADMIN_MAIL, 'Super Visor');	 // Add a recipient
	//$mail->addReplyTo('info@example.com', 'Information');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');

	// Attachments
	//$mail->addAttachment('/var/tmp/file.tar.gz');		 // Add attachments
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');	// Optional name

	// Content
	$mail->isHTML(true);								  // Set email format to HTML
	$mail->Subject = $subject;
	$mail->Body	= $message;
	//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	$mail->send();
	$msg="Registration Successful";
} catch (Exception $e) {
	echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



/*
	// Always set content-type when sending HTML email
	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

	// <Change emials below>
	//$headers .= 'From: <smac2020@ku.ac.ae>' . "\r\n";
	//$headers .= 'Cc: jamal.zemerly@ku.ac.ae' . "\r\n";
	$headers .= 'From: <support@webapplics.com>' . "\r\n";
	$headers .= 'Cc: scmnst@yahoo.com' . "\r\n";
	if(!mail($to,$subject,$message, $headers, "-f" . $from)){
		$msg = 'E-mail sending not successful';
	}else{
		$msg = "Mail sent";
	}*/
}
//var_dump($data);
?><section class="container">
<div id="wrapper">
<div class="wrapper">
<div>
<h1 style="color: #c32e2e; text-align: center; font-weight: 600;">SMAC 2020</h1>
<h4 style="text-align: center; margin-bottom: 13px; color: #c32e2e;">Fill the registration form</h4>
</div>
<div role="form" lang="en-GB" dir="ltr">
<div class="screen-reader-response"><?php
if($msg){
	echo '<script>';
	echo 'alert(' .$msg . ');';
	echo 'windows.location('');';
	echo '</script>';
}
?></div>
<form action="" method="post">

<div id="responsive-form" class="clearfix">
<div class="row">
<div class="col-md-6 col-sm-8">
<div class="form-row">
<div class="form-group col-sm-12"><label>Full Name</label><input type="text" name="title" class="form-text text-muted form-control" value="" required></div>
<div class="form-group col-sm-12"><label>Phone </label><span><input type="text" name="phone" class="form-text text-muted form-control" value="" required></span></div>
<div class="form-group col-sm-12"><label>Email </label><span><input type="email" name="e_mail" class="form-text text-muted form-control" value="" required></span></div>
</div>

<div class="form-row">
<div class="btn-group col-sm-12"><input type="submit" value="Submit" class="btn btn-info" name="submit"><span class="ajax-loader"></span></div>
</div>
</div>
</div>
</div>
</form>
</div>

</div>
</section><?php

require_once 'inc/footer.php';