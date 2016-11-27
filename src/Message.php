<?php
declare(strict_types = 1);

namespace Telegram\Bot;

use GuzzleHttp\Client;

class Message
{
    public static function sendMessage($telegram_updates)
    {
        foreach ($telegram_updates as $obj) {
            $video_id = mb_substr($obj->message->text, -11);
            $get_video_info = Request::getResponseGoogle($video_id);
            if (!empty($get_video_info->items)) {
                $chat_id = $obj->message->chat->id;
                $maxres = reset($get_video_info->items)->snippet->thumbnails->maxres->url;
                $standard = reset($get_video_info->items)->snippet->thumbnails->standard->url;
                if (!empty($maxres)) {
                    Request::sendMessageTelegramChat($chat_id, $maxres);
                } else if (!empty($standard)) {
                    Request::sendMessageTelegramChat($chat_id, $standard);
                } else {
                    Request::sendMessageTelegramChat($chat_id, 'Sorry :(');
                }
            }
        }
    }
}
