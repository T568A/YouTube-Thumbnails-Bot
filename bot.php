#!/usr/bin/env php
<?php
declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

use Telegram\Bot\Request;

$tokens             = require_once __DIR__ . '/tokens.php';
$video_id           = '-JpyiwFTH6s';
$telegram_offset    = 0;
Request::$google_token       = $tokens['Google'];
Request::$telegram_token     = $tokens['Telegram'];

try {

    $get_telegram_updates = Request::getResponseTelegram('getUpdates', $telegram_offset);

    if ($get_telegram_updates->ok === true && !empty($get_telegram_updates->result)) {
        $telegram_offset = end($get_telegram_updates->result)->update_id + 1;
        foreach ($get_telegram_updates->result as $obj) {
            // echo $obj->update_id . PHP_EOL;
            // echo $obj->message->chat->id . PHP_EOL;
            // echo $obj->message->text . PHP_EOL;
            $video_id = $obj->message->text;
            $get_video_info = Request::getResponseGoogle($video_id);
            if (!empty($get_video_info->items)) {
                echo reset($get_video_info->items)->snippet->thumbnails->maxres->url . PHP_EOL;
                Request::sendMessageTelegramChat($obj->message->chat->id, reset($get_video_info->items)->snippet->thumbnails->maxres->url);
            }
        }
    }

} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
}
