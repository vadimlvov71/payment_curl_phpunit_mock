<?php

namespace App\Controller;

use App\Service\CommissionCalculation;
use App\Service\Curl;
use App\Service\Helper;

use App\Entity\UserAgents;

class AppController
{
    private $_file_with_data = "";
    private $_const_currency_list = [];
    private $_currency_url = "";
    private $_exchange_rate_url = "";
    private $_bin_url_type = "";
    private $_exchange_url_type = "";
    private $_euro_currency = "";
    private $_commission_rate_euro_zone = "";
    private $_commission_rate_no_euro_zone = "";

    public function __construct(
        string $file_with_data, 
        array $const_currency_list,
        string $currency_url,
        string $exchange_rate_url,
        string $bin_url_type,
        string $exchange_url_type,
        string $euro_currency,
        string $commission_rate_euro_zone,
        string $commission_rate_no_euro_zone
        
    )
    {
        $this->_file_with_data = $file_with_data;
        $this->_const_currency_list = $const_currency_list;
        $this->_currency_url = $currency_url;
        $this->_exchange_rate_url = $exchange_rate_url;
        $this->_bin_url_type = $bin_url_type;
        $this->_exchange_url_type = $exchange_url_type;
        $this->_euro_currency = $euro_currency;
        $this->_commission_rate_euro = $commission_rate_euro_zone;
        $this->_commission_rate_no_euro_zone = $commission_rate_no_euro_zone;
    } 

    /**
     * @return [type]
     */
    public function index()
    {
        $result["error"] = "error: ";
        $random_user_agent = UserAgents::randomValue();
        //$rows_currencies = [];
        $exchange_rate = Helper::getCurrenciesList($this->_exchange_rate_url, $this->_exchange_url_type, $random_user_agent);
        $calculation = new CommissionCalculation(
            $this->_const_currency_list, 
            $this->_euro_currency,
            $this->_commission_rate_euro,
            $this->_commission_rate_no_euro_zone,
            $exchange_rate
        );
        
   
        $rows_from_file = Helper::getArrayOfObject($this->_file_with_data);
        $url = $this->_currency_url . "45717360";
        //$rows_currencies = Helper::getCountryCard($url, $this->_bin_url_type, $random_user_agent);
        
        echo "<pre>";
        print_r($rows_from_file);
        echo "</pre>"; 
       
        
       //exit;
        if (empty($rows_from_file)) {
            $result["error"] .= "file is empty";
        } else {
            foreach ($rows_from_file as $row) {
                if (empty($row->bin)) {
                    $result["error"] .= "bin is empty";
                } else {
                    $commission = $calculation->getCommissionByZone($row);
          
                    echo "commission:: ".$commission."<br>";
                    $url = $this->_currency_url . $row->bin;
                   //echo "row->bin:: ".$row->bin."<br>";
                    //echo "amount:: ".$row->amount."<br>";
                    //echo "currency:: ".$row->currency."<br>";
                   //$rows_currencies[] = Helper::getCountryCard($url, $random_user_agent);
                   // sleep(2);
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