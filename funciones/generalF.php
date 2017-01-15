<?php

require_once('PHPMailer/class.phpmailer.php');
require_once('PHPMailer/class.smtp.php');

class general{
	public static function enviarEmail($emails, $asunto, $cuerpo){
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

		$mail->Subject = $asunto;

		$mail->Body = $cuerpo;

		foreach ($emails as $valor) {
			$mail->AddAddress($valor);
		}

		if(!$mail->Send()) {

			echo "Error en el mail: " . $mail->ErrorInfo;

		} else {

			echo "El mensaje ha sido enviado";

		}
	}
}


?>