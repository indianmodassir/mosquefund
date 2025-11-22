<?php

use Lazervel\MailSender\MailSender;
use Lazervel\Dotenv\Dotenv;
use Lazervel\Cryptor\Cryptor;

require_once __DIR__.'/../vendor/autoload.php';

$dotenv = Dotenv::process(__DIR__.'/../', '.env');
$dotenv->safeLoad();

$mailsender = new MailSender();
$cryptor = new Cryptor();

if (!defined('cryptor')) {
  define('cryptor', $cryptor);
}
?>