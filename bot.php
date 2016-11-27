#!/usr/bin/env php
<?php
declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

use Telegram\Bot\{Request, Message};
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('my_logger');
$log->pushHandler(new StreamHandler('logs/warning.log', Logger::WARNING));

$tokens = require_once __DIR__ . '/tokens.php';
Request::$google_token = $tokens['Google'];
Request::$telegram_token = $tokens['Telegram'];

$video_id = '';
$telegram_offset = 0;

try {
    while (true) {
        $get_telegram_updates = Request::getResponseTelegram($telegram_offset);
        if ($get_telegram_updates->ok === true && !empty($get_telegram_updates->result)) {
            $telegram_offset = end($get_telegram_updates->result)->update_id + 1;
            Message::sendMessage($get_telegram_updates->result);
        }
        sleep(15);
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
    $log->warning('Error: ' . $e->getMessage() . PHP_EOL);
}
