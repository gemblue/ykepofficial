<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$config['jwt_key'] = $_ENV['JWT_KEY'] ?? 'bncdkvjierjiti2w343024t9qew8asfyvhgji4';

/**
 * Generated token will expire in 1 minute for sample code
 * Increase this value as per requirement for production
 */

$config['token_timeout'] = 3600;