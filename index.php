<?php

use app\ApiLeads;
use GuzzleHttp\Client;

require './vendor/autoload.php';
$config = require 'config.php';

$a = new ApiLeads($config['token_webmaster'], new Client());
var_dump($a->getCountry());