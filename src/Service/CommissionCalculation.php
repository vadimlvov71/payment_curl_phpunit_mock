<?php

namespace App\Service;

use App\Service\Helper;


class CommissionCalculation
{

    public function __construct(
        array $const_currency_list, 
        string $euro_currency,
        string $commission_rate_euro_zone,
        string $commission_rate_no_euro_zone, 
        array $exchange_rate, 
    )
    {
        $this->_const_currency_list = $const_currency_list;
        $this->_euro_currency = $euro_currency;
        $this->_commission_rate_euro_zone = $commission_rate_euro_zone;
        $this->_commission_rate_no_euro_zone = $commission_rate_no_euro_zone;
        $this->_exchange_rate = $exchange_rate;
    }

    public function getCommissionByZone(object $row)
    {
        $commission = 0;
        /*echo "___<pre>";
        print_r($this->_exchange_rate);
        echo "</pre>";*/
        //$currency = 'jpn';
        $is_euro_bank_card = Helper::isEuroBankCardEmitted($row->currency, $this->_const_currency_list); 
        $is_euro_bank_card = true;
       // echo "is_euro_bank_card:: ".$is_euro_bank_card;
        #case euro currency and an euro bank card
        #case euro currency and no euro bank card
        #case no euro currency and an euro bank card
        #case no euro and no euro bank card
        
        if($row->currency == $this->_euro_currency && $is_euro_bank_card === true){
            //echo "case 111::::".$this->_commission_rate_euro_zone."<br>";
            $commission = $row->amount * $this->_commission_rate_euro_zone;
        } elseif ($row->currency == $this->_euro_currency && $is_euro_bank_card === false) {
            //echo "case 222::: ".$row->currency."<br>";
        } elseif ($row->currency != $this->_euro_currency && $is_euro_bank_card === true) {
            $euro_currency_from_exchange = $this->euroCurrencyFromExchange($row); 
            $commission = $euro_currency_from_exchange * $this->_commission_rate_no_euro_zone;
            //echo "case 333::: ".$row->currency."<br>";
        } else {
            //echo "case 444::: ".$row->currency."<br>";
        }
        echo "commission::: ".$commission."<br>";
        $english_format_number = number_format($commission, 2, '.', '');
       return $english_format_number;
    }
    public function euroCurrencyFromExchange($row){
        echo "currency".$row->currency."<br>";
       echo "amount".$row->amount."<br>";
        $rate = $this->_exchange_rate[$row->currency];
        $euro_value = $row->amount / $rate;
        echo "euro_value:: ".$euro_value."<br>";
        return   $euro_value;

    }
    
}