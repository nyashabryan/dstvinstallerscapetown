<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';


function checkValidation($postid){
    $secret = "6LehV1YUAAAAAOxL8r8_RD3W3ADaYypIv4JNPv6Q";
    $secrets =  'secret='.$secret.'&response='.$postid;
    $ch =  curl_init();

    curl_setopt($ch, CURLOPT_URL, 'https://www.google.com/recaptcha/api/siteverify');

    curl_setopt($ch, CURLOPT_POST, true);

    curl_setopt($ch, CURLOPT_POSTFIELDS, $secrets);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $ans = curl_exec($ch);

    echo $ans;
    
    $data =  json_decode($ans);

    $result =  $data->success;

    return $result;

}

$emailTo = 'sales@dstvinstallerscapetown.co.za';

if (isset($_POST)){

    $code =  $_POST['g-recaptcha-response'];
    if (!checkValidation($code)) exit;
    $emailFrom = $_POST['email'];
    $emailFromName = $_POST['name'];
    $emailToName = $_POST['Sales'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    $phone = $_POST['phone'];

    $emailbody = $name.'\r\n'.$email.'\r\n'.$phone.'\r\n'.$subject.'\r\n'.'\r\n'.$message;
    $mail = new PHPMailer;
    $mail->setFrom($emailFrom, $emailFromName);
    $mail->addAddress($emailTo, $emailToName);
    $mail->Subject = $subject;
    $mail->Body = $emailbody; 
    $mail->AltBody = $emailbody;
    
    
    if(!$mail->send()){
        echo "Mailer Error: " . $mail->ErrorInfo;
        header("Location: http://www.dstvinstallerscapetown.co.za/messagenotsent/index.html/#formresponse");
    }else{
        echo "Message sent!";
        header("Location: http://www.dstvinstallerscapetown.co.za/messagesent");
    }
    
}else{
    header('Location: http://www.dstvinstallerscapetown.co.za/#contact');
}


?>