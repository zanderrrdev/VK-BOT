<?php

require __DIR__ . '/vendor/autoload.php';

use App\utils\Config;
use App\utils\MainLogger;
use App\Bot;
use App\Swoole;

MainLogger::log('Loading config.yml...', 'info');
$config = new Config(__DIR__ . '/resource/config.yml');
$code = $config->get('vk.code');

MainLogger::log('[Callback API] Confirmation code: ' . $code, 'notice');
MainLogger::log('Initializing VK-BOT version v1.0.0', 'info');

$bot = new Bot($config);
$server = new Swoole($bot, $code);

$server->start();