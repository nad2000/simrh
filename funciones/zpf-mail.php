<?
require_once("phpmailer/class.phpmailer.php");


function enviamail($Addr,$Subjetc,$Content,$attachs=null)
{
	$mail = new PHPMailer();
	$mail->IsSMTP();                                   // send via SMTP
	$mail->Host     = "132.248.107.100:25"; // SMTP servers
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->Username = "cistimex@biomedicas.unam.mx";  // SMTP username
	$mail->Password = "viri18"; // SMTP password
	
	$mail->From     = "cistimex@biomedicas.unam.mx";
	$mail->FromName = "Cistimex";
	$mail->AddAddress($Addr); 
	
	$mail->WordWrap = 50; 
	
	foreach($attachs as $attach)
	{
		$mail->AddAttachment("$attach");
	}

	$mail->IsHTML(true);                               // send as HTML
	$mail->Subject  =  $Subjetc;
	$mail->Body     =  $Content;
	
/*	if(!$mail->AddEmbeddedImage("./hola.jpg", "my-attach", "hola.jpg",
									  "base64", "image/jpg"))
	{
		$mail->assert(false, $this->Mail->ErrorInfo);
		return;
	}*/

	//$mail->AltBody  =  "This is the text-only body";	
	if(!$mail->Send())
	{
	   echo "No se pueden enviar mensajes<br>";
	   echo "Error:  " . $mail->ErrorInfo;
	   ?><br><a href="administrador.php">Volver al editor</a><?
	   exit;
	}	
	//chek('mensaje enviado');
}

?>
