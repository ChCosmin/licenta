<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
  include('../assets/PHPMailer/src/Exception.php');
  include('../assets/PHPMailer/src/PHPMailer.php');
  include('../assets/PHPMailer/src/SMTP.php');

  $mail = new PHPMailer(true);
  try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                            // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'kibaboyro@gmail.com';                 // SMTP username
    $mail->Password = 'Parolagmail0';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('kibaboyro@gmail.com', 'Mailer');
    $mail->addAddress('cosmin.chinde@gmail.com', 'Joe User');     // Add a recipient

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'Here is the subject';
    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

    $message = 'Message has been sent';
    echo "<script type='text/javascript'>alert('$message');</script>";
  
} catch (Exception $e) {
    $message = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
    echo "<script type='text/javascript'>alert('$message');</script>";
}
?>