#!/usr/bin/env php
<?php
declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

use Telegram\Bot\{Request, Message};

$tokens             = require_once __DIR__ . '/tokens.php';
$video_id           = '-JpyiwFTH6s';
$telegram_offset    = 0;
Request::$google_token       = $tokens['Google'];
Request::$telegram_token     = $tokens['Telegram'];

try {
    while(true){
        $get_telegram_updates = Request::getResponseTelegram('getUpdates', $telegram_offset);
        if ($get_telegram_updates->ok === true && !empty($get_telegram_updates->result)) {
            $telegram_offset = end($get_telegram_updates->result)->update_id + 1;
            Message::sendMessage($get_telegram_updates->result);
        }
        sleep(15);
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
