<?php
use App\Controller\AppController;

require_once __DIR__ . '/config/env.php';

require __DIR__ . '/vendor/autoload.php';


$app = new AppController(
    FILE_WITH_DATA, 
    CONST_COUNTRIES_CURRENCY_LIST, 
    CURRENCY_URL,
    EXCHANGE_RATE_URL,
    BIN_URL_TYPE,
    EXCHANGE_URL_TYPE,
    EURO_CURRENCY,
    COMMISSION_RATE_EURO_ZONE,
    COMMISSION_RATE_NO_EURO_ZONE,
    FILE_TO_COMMISSION
);
$result = $app->index();


