<?php

namespace App\Controller;

use App\Service\Helper;
use App\Service\Curl;
use App\Entity\UserAgents;

class AppController
{
    private $_file_with_data = "";
    private $_currency_list = [];
    private $_currency_url = "";
    private $_exchange_rate_url = "";
    private $_bin_url_type = "";
    private $_exchange_url_type = "";
    private $_commission_rate_euro = "";
    private $_commission_rate_no_euro = "";

    public function __construct(
        string $file_with_data, 
        array $currency_list,
        string $currency_url,
        string $exchange_rate_url,
        string $bin_url_type,
        string $exchange_url_type
    )
    {
        $this->_file_with_data = $file_with_data;
        $this->_currency_list = $currency_list;
        $this->_currency_url = $currency_url;
        $this->_exchange_rate_url = $exchange_rate_url;
        $this->_bin_url_type = $bin_url_type;
        $this->_exchange_url_type = $exchange_url_type;
    } 

    /**
     * @return [type]
     */
    public function index()
    {
        $result["error"] = "error: ";
        //$rows_currencies = [];
        $currency = 'LV';
        //$currency = 'jpn';
        $is_euro_currency = Helper::isEuro($currency, $this->_currency_list); 
        echo "is_euro_currency:: ".$is_euro_currency;
        if($is_euro_currency === false){
            echo "result:: false";
        }
        $random_user_agent = UserAgents::randomValue();
        //echo "random_user_agent:: ".$random_user_agent."<br>";
   
        $rows_from_file = Helper::getArrayOfObject($this->_file_with_data);
        $url = $this->_currency_url . "45717360";
        $rows_currencies = Helper::getCountryCard($url, $this->_bin_url_type, $random_user_agent);
        //$currencies_list = Helper::getCurrenciesList($this->_exchange_rate_url, $random_user_agent);
        echo "<pre>";
        print_r($rows_from_file);
        echo "</pre>"; 
        echo "<pre>";
        print_r($rows_currencies);
        echo "</pre>";
        
        exit;
        if (empty($rows_from_file)) {
            $result["error"] .= "file is empty";
        } else {
            foreach ($rows_from_file as $row) {
                if (empty($row->bin)) {
                    $result["error"] .= "bin is empty";
                } else {
                    $url = $this->_currency_url . $row->bin;
                   // echo "row->bin:: ".$row->bin."<br>";
                    //echo "amount:: ".$row->amount."<br>";
                    //echo "currency:: ".$row->currency."<br>";
                   $rows_currencies[] = Helper::getCountryCard($url, $random_user_agent);
                    sleep(2);
                }
            }
        }
        
        //
        echo "<pre>";
        print_r($rows_currencies);
        echo "</pre>";
        echo "<pre>";
        print_r($result);
        echo "</pre>";        
        //return $rows_as_json;
    }
    
}