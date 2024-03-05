<?php

namespace App\Service;

use App\Service\Helper;

class CommissionCalculation
{
    public function __construct(
        private array $const_currency_list,
        private string $euro_currency,
        private string $commission_rate_euro_zone,
        private string $commission_rate_no_euro_zone,
        private array $exchange_rate,
    ) {
        $this->_const_currency_list = $const_currency_list;
        $this->_euro_currency = $euro_currency;
        $this->_commission_rate_euro_zone = $commission_rate_euro_zone;
        $this->_commission_rate_no_euro_zone = $commission_rate_no_euro_zone;
        $this->_exchange_rate = $exchange_rate;
    }

    /**
     * @param object $row
     * @param string $currency_state_name
     *
     * @return string
     */
    public function getCommissionByZone(object $row, string $currency_state_name): string
    {
        $commission = 0;
        $is_euro_bank_card = Helper::isEuroBankCardEmitted($currency_state_name, $this->_const_currency_list);
        $is_euro_bank_card = true;
       // echo "is_euro_bank_card:: ".$is_euro_bank_card;
        #case euro currency and an euro bank card
        #case euro currency and no euro bank card
        #case no euro currency and an euro bank card
        #case no euro and no euro bank card
        if ($row->currency == $this->_euro_currency && $is_euro_bank_card === true) {
            $commission = $row->amount * $this->_commission_rate_euro_zone;
        } elseif ($row->currency == $this->_euro_currency && $is_euro_bank_card === false) {
            //TO DO
        } elseif ($row->currency != $this->_euro_currency && $is_euro_bank_card === true) {
            $euro_currency_from_exchange = $this->euroCurrencyFromExchange($row);
            $commission = $euro_currency_from_exchange * $this->_commission_rate_no_euro_zone;
        } else {
            //TO DO
        }
        $english_format_number = number_format($commission, 2, '.', '') . PHP_EOL;
        return $english_format_number;
    }

    /**
     * @param object $row
     *
     * @return float
     */
    public function euroCurrencyFromExchange(object $row): float
    {
        $rate = $this->_exchange_rate[$row->currency];
        $euro_value = $row->amount / $rate;
        return $euro_value;
    }
}
