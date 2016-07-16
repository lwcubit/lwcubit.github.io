<?php
//DEFINE GLOBALS
$ERRORURL = "https://dl.dropboxusercontent.com/u/501871531/MensMinistry/HTML/ContactUs_Error.html";
$DONEURL = "https://dl.dropboxusercontent.com/u/501871531/MensMinistry/HTML/ContactUs_sent.html";
function processForm() {
	//check for values
	if (validateFormData()) {
		$result = sendMessage();
		if ($result) {
			returnPage("ok");
		} else {
			returnPage("error");
		}
	} else {
		returnPage("error");
	}
}
function validateFormData() {
	//makes sure all the values are set
	//double-check even if client validates.
	if (isElementSet('name'))
		if (isElementSet('email'))
			if (isElementSet('comments'))
				return TRUE;
			else
				return FALSE;
}
function isElementSet($key) {
	$ele = $_POST[$key];
	if (isset($ele)) {
		return TRUE;
	} else {
		return FALSE;
	}
}
function sendMessage() {
	//sends mail message to specified account
	require_once ('../vendor/phpmailer/phpmailer/class.phpmailer.php');
	include ("../vendor/phpmailer/phpmailer/class.smtp.php");
	// optional, gets called from within class.phpmailer.php if not already loaded
	$mail = new PHPMailer();
	//TODO: extract from $data
	//TODO: Build body test
	//TODO: write backup to file on server for log
	$name = $_POST["name"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	$comments = $_POST["comments"];
	$body = "A message has been received. \r\n<br>Name: $name <br>\r\n E-mail: $email \r\n<br> Phone: $phone \r\n<br> Comments: $comments";
	//file_get_contents('contents.html');
	$body = eregi_replace("[\]", '', $body);
	$mail -> IsSMTP();
	// telling the class to use SMTP
	//$mail -> Host = "smtp.gmail.com";
	// SMTP server
	$mail -> SMTPDebug = 0;
	// enables SMTP debug information (for testing)
	// 1 = errors and messages
	// 2 = messages only
	$mail -> SMTPAuth = true;
	$mail -> SMTPSecure = 'ssl';
	// enable SMTP authentication
	$mail -> Host = "smtp.gmail.com";
	// sets the SMTP server
	$mail -> Port = 465;
	// set the SMTP port for the GMAIL server
	$mail -> Username = "webmaster.alcc.mensministry@gmail.com";
	// SMTP account username
	$mail -> Password = "Temp1235";
	// SMTP account password
	$mail -> ClearReplyTos();
	$mail -> AddReplyTo('admin@alcc-mensministry.org', 'admin@alcc-mensministry.org');
	$mail -> SetFrom('admin@alcc-mensministry.org', 'admin@alcc-mensministry.org');
	$mail -> Subject = "RE: Contact Info from www.alcc-mensministry.org ";
	$mail -> AltBody = "To view the message, please use an HTML compatible email viewer!";
	// optional, comment out and test
	$mail -> MsgHTML($body);
	$address ="admin@alcc-mensministry.org";
	
	$mail -> AddAddress($address, "WebAdmin");
	//$mail -> AddAttachment("images/phpmailer.gif");
	// attachment option
	//$mail->send();
	if (!$mail -> Send()) {
		//echo "Mailer Error: " . $mail -> ErrorInfo;
		return FALSE;
	} else {
		return TRUE;
	}
}
function returnPage($page) {
	//echo $page;
	if ($page == "ok") {
		//return user to a thank you page on the client server.
		header("Location: " . $GLOBALS['DONEURL']);
	} else {
		//there was an error; send user back to try the form again
		header("Location: " . $GLOBALS['ERRORURL']);
	}
}
processForm();
?>
Contact GitHub API Training Shop Blog About
© 2016 GitHub, Inc. Terms Privacy Security Status Help
