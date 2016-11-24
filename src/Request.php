<?php
declare(strict_types = 1);

namespace Telegram\Bot;

use GuzzleHttp\Client;

class Request
{
    public static $google_token;
    public static $telegram_token;
    private static $base_google_uri = 'https://www.googleapis.com/youtube/v3/videos?key=';
    private static $base_telegram_uri = 'https://api.telegram.org/bot';


    public static function guzzleClient()
    {
        return new Client(['timeout' => 3.0]);
    }

    public static function getResponseTelegram(int $telegram_offset)
    {
        $uri = self::$base_telegram_uri . self::$telegram_token . '/getUpdates?offset=' . $telegram_offset;

        return json_decode((string)self::guzzleClient()->request('GET', $uri)->getBody());
    }

    public static function getResponseGoogle(string $id)
    {
        $uri = self::$base_google_uri . self::$google_token . '&part=snippet&id=' . $id;

        return json_decode((string)self::guzzleClient()->request('GET', $uri)->getBody());
    }

    public static function sendMessageTelegramChat(int $chat_id, string $text)
    {
        $uri = self::$base_telegram_uri . self::$telegram_token . '/' . 'sendMessage?chat_id=' . $chat_id . '&text=' . $text;

        return json_decode((string)self::guzzleClient()->request('GET', $uri)->getBody());
    }
}
