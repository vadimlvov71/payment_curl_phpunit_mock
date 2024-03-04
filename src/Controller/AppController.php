<?php

namespace App\Controller;

use App\Service\CommissionCalculation;
use App\Service\Curl;
use App\Service\Helper;

use App\Entity\UserAgents;

class AppController
{
   

    public function __construct(
        # use new php8 feature:
        private string $file_with_data, 
        private array $const_currency_list,
        private string $currency_url,
        private string $exchange_rate_url,
        private string $bin_url_type,
        private string $exchange_url_type,
        private string $euro_currency,
        private string $commission_rate_euro_zone,
        private string $commission_rate_no_euro_zone,
        private string $file_to_commission_result
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
        $this->_file_to_commission_result = $file_to_commission_result;
    } 

    /**
     * @return [type]
     */
    public function index()
    {
        $result["error"] = "error: ";
        $commission = "";

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
        
        //exit;
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
                    $url = $this->_currency_url . "45717360";
                    $currency_state_name = Helper::getCountryCard($url, $this->_bin_url_type, $random_user_agent);
                    /*echo "<pre>";
                    print_r($rows_currencies);
                    echo "</pre>";*/
                    $commission .= $calculation->getCommissionByZone($row, $currency_state_name);
          
                    echo "commission:: ".$commission."<br>";
                    $url = $this->_currency_url . $row->bin;
                   echo "row->bin:: ".$row->bin."<br>";
                    //echo "amount:: ".$row->amount."<br>";
                    //echo "currency:: ".$row->currency."<br>";
                   //$rows_currencies[] = Helper::getCountryCard($url, $random_user_agent);
                   // sleep(2);
                }
            }
        }
        $result["file"] = Helper::setDataToFile($commission, $this->_file_to_commission_result);
        //
        
        echo "<pre>";
        print_r($result);
        echo "</pre>";        
        //return $rows_as_json;
    }
    
}