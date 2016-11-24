<?php
declare(strict_types = 1);

namespace Telegram\Bot;

use GuzzleHttp\Client;

class Request
{
    private static $base_telegram_uri   = 'https://api.telegram.org/bot';
    private static $base_google_uri     = 'https://www.googleapis.com/youtube/v3/videos?key=';

    // TODO: add Async Requests
    public static function getTelegram(string $telegram_token, string $method)
    {
        return json_decode((string)(new Client([
                'base_uri' => self::$base_telegram_uri . $telegram_token . '/',
                'timeout' => 2.0,
            ]
        ))->request('GET', $method)->getBody());
    }

    public static function getGoogle(string $google_token, string $id)
    {
        return json_decode((string)(new Client([
                'base_uri' => self::$base_google_uri . $google_token . '&part=snippet&id=' . $id,
                'timeout' => 2.0,
            ]
        ))->request('GET')->getBody());
    }
}
