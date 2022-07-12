<?php
include 'DBConnect.php';
if (!isset($_SESSION))
{
	session_start();
}
$email=$_SESSION['tempemail'];
$username=$_SESSION['tempusername'];
$name=$_SESSION['name'];
$pager=$_SESSION['pager'];
$timestamp = time();

# code...
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';


// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
$otp = rand(100000,999999);
try {
//Server settings
$mail->SMTPDebug = 0;                      // Enable verbose debug output
$mail->isSMTP();                                            // Send using SMTP
$mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
$mail->Username   = 'mailingsystem.epharma@gmail.com';                     // SMTP username
$mail->Password   = 'national789';                               // SMTP password
// $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

//Recipients
$mail->setFrom('mailingsystem.epharma@gmail.com', 'ePharma Nepal');
$mail->addAddress($email,$name);     // Add a recipient
//$mail->addAddress('ellen@example.com');               // Name is optional
// $mail->addReplyTo('info@example.com', 'Information');
// $mail->addCC('cc@example.com');
// $mail->addBCC('bcc@example.com');

// Attachments
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
// $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

// Content

$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'ePharma Registration OTP code';
$mail->Body    = 'Your OTP code is '. $otp;
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
$mail->send();

} catch (Exception $e) {
echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
exit;
}

$sql = "SELECT `username` FROM `otp` WHERE `username`='$username'";
$result = mysqli_query($conn,$sql);
if (mysqli_num_rows($result)!=0)
	{
		$sql = "DELETE FROM `otp` WHERE `username` = '$username'";
		mysqli_query($conn,$sql);
	}

$sql = "INSERT INTO `otp`(`username`, `otpcode`,`timestamp`) VALUES ('$username','$otp','$timestamp')";
if (mysqli_query($conn,$sql))
{
	if ($pager=="verify")
	{
		header('Location: email_verification.php');
	}
	else if($pager=="resetpassword")
	{
		header('Location: change_password.php');
	}
}
else
{
	echo "Couldn't generate an OTP, please try again later";
}


?>