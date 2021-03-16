<?php

function sendEmail($to, $subject, $data, $template, $async = false, $asyncPriority = 3, $asyncExpire = false)
{
	if ($_ENV['SEND_EMAIL'] != true)
		return true;

	if($async)
	{
		$payload['to'] 		= $to;
		$payload['subject'] = $subject;
		$payload['data'] 	= $data;
		$payload['template']= $template;

		$queue = new App\cli\Queue;
		$queue->placeQueue('email', $payload, $asyncPriority, $asyncExpire);
		return 'message queued';
	}

	$CI = &get_instance();

	$CI->load->library('email', [
		'protocol'  => 'smtp',
		'smtp_host' => $_ENV['SMTP_HOST'] ?? 'localhost',
		'smtp_port' => $_ENV['SMTP_PORT'] ?? 1025,
		'smtp_user' => $_ENV['SMTP_USER'] ?? '',
		'smtp_pass' => $_ENV['SMTP_PASS'] ?? '',
		'mailtype'  => 'html', 
		'charset'   => 'iso-8859-1'
	]);

	$CI->email->set_newline("\r\n");
	$CI->email->from($_ENV['EMAIL_FROM_ADDRESS'] ?? 'info@codepolitan.com', $_ENV['EMAIL_FROM_NAME'] ?? 'Codepolitan Info');
	$CI->email->to($to); 
	$CI->email->subject($subject);

	extract($data);
	ob_start();
	include(SITEPATH.'resources/email_templates/'.$template.'.php');
	$buffer = ob_get_contents();
	@ob_end_clean();

	$CI->email->message($buffer);  

	return $CI->email->send();
}