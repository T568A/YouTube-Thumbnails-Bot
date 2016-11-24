#!/usr/bin/env php
<?php
declare(strict_types = 1);

require_once __DIR__ . '/vendor/autoload.php';

use Telegram\Bot\Request;

$tokens         = require_once __DIR__ . '/tokens.php';
$google_token   = $tokens['Google'];
$telegram_token = $tokens['Telegram'];
$video_id       = '6m4XPje76WU';

var_dump(Request::getTelegram($telegram_token, 'getUpdates'));
var_dump(Request::getTelegram($telegram_token, 'getMe'));

var_dump(Request::getGoogle($google_token, $video_id));
