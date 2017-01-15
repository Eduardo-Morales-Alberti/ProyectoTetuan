<?php

//require 'PHPMailerAutoload.php';
 include_once('class.phpmailer.php');



 require_once('class.smtp.php');


$mail = new PHPMailer(); // create a new object

$mail->IsSMTP(); // enable SMTP

$mail->SMTPDebug = false; // debugging: 1 = errors and messages, 2 = messages only

$mail->SMTPAuth = true; // authentication enabled

$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail

//$mail->Host = "smtp.gmail.com";

$mail->Host = "cp204.webempresa.eu";
$mail->Port = 465; // or 587

$mail->IsHTML(true);

$mail->Username = "contacto@momentosenlata.es";

$mail->Password = "alumno";

$mail->SetFrom("contacto@momentosenlata.es");

$mail->Subject = "Test5";

$mail->Body = "hello5";

$mail->AddAddress("eduardomoberti@hotmail.com");



 if(!$mail->Send()) {

    echo "Error en el mail: " . $mail->ErrorInfo;

 } else {

    echo "El mensaje ha sido enviado";

 }