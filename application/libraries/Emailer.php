<?php namespace App\libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/** 
 * Email sender class
 * Email template placed in [sitefolder]/resources/email_templates
 *
 */
class Emailer {

	private $mail;

	public $async = false;

	public $from;
	public $to;
	public $subject;
	public $body;

	public function __construct()
	{
		// $this->mail = new PHPMailer(true); // For debugging 
	    // $this->mail->SMTPDebug = 2;
		$this->mail = new PHPMailer(); 

		$this->mail->isSMTP();

		if(setting_item('emailer.use_mailcatcher') == 'yes'){
		    $this->mail->Host       = 'localhost';
			$this->mail->Port       = 1025;
			$this->mail->Username   = '';
			$this->mail->Password   = '';
		} else {
		    $this->mail->Host       = setting_item('emailer.smtp_host') ?? 'localhost';
			$this->mail->Port       = setting_item('emailer.smtp_port') ?? 1025;
			$this->mail->Username   = setting_item('emailer.smtp_username') ?? '';
			$this->mail->Password   = setting_item('emailer.smtp_password') ?? '';
			$this->mail->SMTPSecure = 'tls';
			$this->mail->SMTPAuth   = true;
		}

		// Set default sender from setting
		$this->mail->setFrom(setting_item('emailer.email_from'), setting_item('emailer.sender_name'));
	}

	public function send($template = false, $data = [])
	{
		if (($_ENV['SEND_EMAIL'] ?? null) == false) return true;

		try { 
			if($this->from)
				$this->mail->setFrom(is_array($this->from) ? $this->from[0] : $this->from, $this->from[1] ?? null);

			$this->mail->addAddress(is_array($this->to) ? $this->to[0] : $this->to, $this->to[1] ?? null);
			$this->mail->isHTML(true);
			$this->mail->Subject = $this->subject;
			$this->mail->Body    = $template ? $this->parseTemplate($template, $data) : $this->body;

			$this->mail->send();

		} catch (Exception $e) { 
		    echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}"; 
		}
	}

	private function parseTemplate($template, $data)
	{
		extract($data);
		ob_start();
		include(SITEPATH.'resources/email_templates/'.$template.'.php');
		$buffer = ob_get_contents();
		@ob_end_clean();

		return $buffer;
	}

}