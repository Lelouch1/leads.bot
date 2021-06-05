<?php

use app\ApiLeads;
use GuzzleHttp\Client;
use TelegramBot\Api\Client as TelegramClient;

require './vendor/autoload.php';
$config = require 'config.php';

$apiToken = $config['token_webmaster'];
$botToken = $config['token_telegram'];


try {
    $bot = new TelegramClient($botToken);
    $leadsApi = new ApiLeads($apiToken, new Client());

    $bot->command('getaccountinfo', function ($message) use ($bot, $leadsApi) {
        $bot->sendMessage($message->getChat()->getId(), $leadsApi->getAccountInfo());
    });

    $bot->command('getcountry', function ($message) use ($bot, $leadsApi) {
        $bot->sendMessage($message->getChat()->getId(), $leadsApi->getCountry());
    });

    $bot->run();

} catch (\TelegramBot\Api\Exception $e) {
    echo $e->getMessage();
}