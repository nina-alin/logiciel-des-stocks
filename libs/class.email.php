<?php
require_once($_SERVER ['DOCUMENT_ROOT'] . '/libs/phpmailer/class.phpmailer.php');
require_once($_SERVER ['DOCUMENT_ROOT'] . '/libs/phpmailer/class.smtp.php');
require_once($_SERVER ['DOCUMENT_ROOT'] . '/libs/phpmailer/extras/EasyPeasyICS.php');
/**
 * Description de la Classe EMAIL (TRAITEUR)
 *
 * @author Sylvain PETIT
 * @date 24/01/18
 * @update 24/01/18
 */
class email {
		
	/**
	 * Constructeur
	 */
	public function __construct($sujet, $msg, $destinataire ) {
		global $SMTP_host;
		global $SMTP_port;
		global $SMTP_user;
		global $SMTP_password;

		$message = $msg;
		
		/*
		$invite = new EasyPeasyICS();
		$invite->addEvent('06-06-2014 08:00:00','06-06-2014 17:00:00',"TEST","TEST","");
		*/
		$mail = new PHPMailer(true);
		$mail->Host = $SMTP_host;
		$mail->Port = $SMTP_port;
		$mail->IsSMTP();
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Username = $SMTP_user;
		$mail->Password = $SMTP_password;
		
		$mail->SetFrom($SMTP_user, '[ent.crous-lille.fr]');
		$mail->Priority = 1;
		$mail->AddCustomHeader("X-MSMail-Priority: High");
		$mail->AddCustomHeader("Importance: High");
		$mail->addReplyTo($SMTP_user, 'NOREPLY - Ne pas répondre');
		//$mail->addAddress('benoit.goales@crous-lille.fr', 'BENOIT GOALES'); // destinataire
		$mail->addAddress($destinataire, $destinataire); // destinataire
		$mail->SMTPDebug = 0;
		$mail->IsHTML(true);
		
		$mail->Subject  = $sujet;
		$mail->MsgHTML($message);
		
		/*
		$mail->Body = $invite;
		//$mail->AltBody = "TEST CALENDAR";
		$mail->Ical = $invite;*/
		return $mail->send();
	}
	
	

}
