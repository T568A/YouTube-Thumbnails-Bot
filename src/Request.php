<?php
declare(strict_types = 1);

namespace Telegram\Bot;

use GuzzleHttp\Client;

class Request
{
    public static $google_token;
    public static $telegram_token;
    private static $base_google_uri     = 'https://www.googleapis.com/youtube/v3/videos?key=';
    private static $base_telegram_uri   = 'https://api.telegram.org/bot';

    public static function getResponseTelegram(string $method, int $telegram_offset)
    {
        return json_decode((string)(new Client([
                'base_uri' => self::$base_telegram_uri . self::$telegram_token . '/',
                'timeout' => 2.0,
            ]
        ))->request('GET', $method . '?offset=' . $telegram_offset)->getBody());
    }

    public static function getResponseGoogle(string $id)
    {
        return json_decode((string)(new Client([
                'base_uri' => self::$base_google_uri . self::$google_token . '&part=snippet&id=' . $id,
                'timeout' => 2.0,
            ]
        ))->request('GET')->getBody());
    }

    public static function sendMessageTelegramChat(int $chat_id, string $text)
    {
        return json_decode((string)(new Client([
                'base_uri' => self::$base_telegram_uri . self::$telegram_token . '/',
                'timeout' => 2.0,
            ]
        ))->request('GET', 'sendMessage?chat_id=' . $chat_id . '&text=' . $text)->getBody());
    }


}
