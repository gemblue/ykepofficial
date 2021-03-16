<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// To use reCAPTCHA, you need to sign up for an API key pair for your site.
// link: http://www.google.com/recaptcha/admin
$config['recaptcha_site_key'] = $_ENV['RECAPTCHA_SITE_KEY'] ?? '6LcFfVkUAAAAAKqPOitOzthA88792BCihdH5sk4P';
$config['recaptcha_secret_key'] = $_ENV['RECAPTCHA_SECRET_KEY'] ?? '6LcFfVkUAAAAAN-uiJNb1GKjk6CgAZ8KM-HEU-Ux';

// reCAPTCHA supported 40+ languages listed here:
// https://developers.google.com/recaptcha/docs/language
$config['recaptcha_lang'] = 'en';

/* End of file recaptcha.php */
/* Location: ./application/config/recaptcha.php */
