<?php
    session_start();
	require_once('src/PHPMailer.php');
	require_once('src/SMTP.php');
	require_once('src/Exception.php');

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	$mail = new PHPMailer(true);

	try{
		$mail->SMTPDebug = SMTP::DEBUG_SERVER;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Username = "rvwigualzynhoMaltainos@gmail.com";
		$mail->Password = "Maltainos2020";
		$mail->Port = 587;

		$mail->setFrom('rvwigualzynhoMaltainos@gmail.com');
        $email = $_POST['email'];
		$mail->addAddress("zaonanelson@gmail.com");


		$mail->isHTML(true);
		$mail->Subject = $_POST['subject'];
		$mail->Body = "<br> Nome  :{$_POST['name']} <br> Email  :{$email}<br> Messagem  :{$_POST['message']} ";

        $_SESSION['email'] = "Obrigado... Recebemos seu email, entraremos em contacto brevemente";
		header("location:contact-us");
	}catch(Exception $e){
		$_SESSION['linkEnviado'] = "Erro ao enviar o email, por favor entre em contacto com um especilista em desenvolvimento";
		//header("Location:usuarios.php");
	}
?>