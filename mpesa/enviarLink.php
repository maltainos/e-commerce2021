<?php
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
		$mail->addAddress($email);


		$mail->isHTML(true);
		$mail->Subject = "Recebemos o seu pedido de redifinicao de senha";
		$mail->Body = "Click no link para redefinir sua senha <a href='http://saepsilon.com/confirmaccount.php?id={$usuario_id}'>Click aqui</a>";


		$mail->AltBody = "Use o link para redefinir sua senha <a href='http://saepsilon.com/confirmaccount.php?id={$usuario_id}'>Click aqui</a>";
		}
	}catch(Exception $e){
		$_SESSION['linkEnviado'] = "Erro ao enviar o email, por favor entre em contacto com um especilista em desenvolvimento";
		//header("Location:usuarios.php");
	}
?>