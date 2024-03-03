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
    COMMISSION_RATE_NO_EURO_ZONE
);
$rows = $app->index();
echo "<pre>";
print_r($rows);
echo "</pre>";
exit;
$bin = "516793";
$url = GET_CURRENCY_URL . "/" . $bin;
$rows = $app->getCurrency($url);
echo "<pre>";
print_r($rows);
echo "</pre>";

foreach ($rows as $row) {
    echo "aaa:: ".$row->bin."<br>";

   // $binResults = file_get_contents('https://lookup.binlist.net/' .$value[0]);
    //sleep(2);
    /*echo "<pre>";
    print_r($value[2]);
    echo "</pre>";*/
}
//$rate = json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true)['rates']["EUR"];
/*echo "<pre>";
    print_r($rate);
    echo "</pre>";*/
exit;
foreach (explode("\n", file_get_contents($argv[1])) as $row) {

    if (empty($row)) break;
    $p = explode(",",$row);
    $p2 = explode(':', $p[0]);
    $value[0] = trim($p2[1], '"');
    $p2 = explode(':', $p[1]);
    $value[1] = trim($p2[1], '"');
    $p2 = explode(':', $p[2]);
    $value[2] = trim($p2[1], '"}');

    $binResults = file_get_contents('https://lookup.binlist.net/' .$value[0]);
    if (!$binResults)
        die('error!');
    $r = json_decode($binResults);
    $isEu = isEu($r->country->alpha2);

    $rate = @json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true)['rates'][$value[2]];
    if ($value[2] == 'EUR' or $rate == 0) {
        $amntFixed = $value[1];
    }
    if ($value[2] != 'EUR' or $rate > 0) {
        $amntFixed = $value[1] / $rate;
    }

    echo $amntFixed * ($isEu == 'yes' ? 0.01 : 0.02);
    print "\n";
}

