<?php

namespace App\Controller;

use App\Service\CommissionCalculation;
use App\Service\Curl;
use App\Service\Helper;
use App\Entity\UserAgents;

/**
* @author Vadim Podolyan <vadim.podolyan@gmail.com>

    * Idea is to calculate commissions for already made transactions;
    *Transactions are provided each in it's own line in the input file, in JSON;
    *BIN number represents first digits of credit card number. They can be used to resolve country where the card was issued;
    *We apply different commission rates for EU-issued and non-EU-issued cards;
    *We calculate all commissions in EUR currency.
 */
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
    ) {
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
     * @return array
     */
    public function index(): array
    {
        $result["error"] = "error: ";
        $commission_string = "";

        $random_user_agent = UserAgents::randomValue();

        $exchange_rate = Helper::getCurrenciesList(
            $this->_exchange_rate_url,
            $this->_exchange_url_type,
            $random_user_agent
        );

        $calculation = new CommissionCalculation(
            $this->_const_currency_list,
            $this->_euro_currency,
            $this->_commission_rate_euro,
            $this->_commission_rate_no_euro_zone,
            $exchange_rate
        );

        $rows_from_file = Helper::getArrayOfObject($this->_file_with_data);

        if (empty($rows_from_file)) {
            $result["error"] .= "file is empty";
        } else {
            foreach ($rows_from_file as $row) {
                if (empty($row->bin)) {
                    $result["error"] .= "bin is empty";
                } else {
                    //$result["bin"][] = $row->bin;
                    $url = $this->_currency_url . $row->bin;
                    $currency_state_name = Helper::getCountryCard($url, $this->_bin_url_type, $random_user_agent);
                    $commission = $calculation->getCommissionByZone($row, $currency_state_name);
                    $commission_string .= $commission;
                    $result["commission"][] = $commission;
                    // sleep(2);
                }
            }
        }
        $result["file_input_data"] = Helper::setDataToFile($commission_string, $this->_file_to_commission_result);
        //
        return $result;
    }
}
