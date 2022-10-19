<?php
namespace Javad\Binance;

use BinanceInsertCurrency;

class BinanceGetData
{

    protected $accountApi;
    protected $insertCurrency;

    public function __construct(BinanceAccountApi $accountApi, BinanceInsertCurrency $insertCurrency)
    {
        $this->accountApi = $accountApi;
        $this->insertCurrency = $insertCurrency;
    }

    /**
     * @throws \Exception
     */
    public function getMyCrypto()
    {
        $data = [];
        try {
            $crypto = $this->accountApi->getBalances();
            if (empty($crypto)) {
                throw new \Exception('crypto failed');
            }
            foreach ($crypto as $key => $value) {
                if ($value['free'] > 0) {
                    $data [] = $crypto[$key];
                }
            }
            $this->insertCurrency->CurrencyInsert($data);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}