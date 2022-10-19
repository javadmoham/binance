<?php
namespace Javad\Binance;

class BinanceInsertCurrency
{

    protected $currencyModel;
    protected $directionModel;
    protected $decimalPoint         = 4;
    protected $direction_wage       = 0.00;
    protected $direction_rate       = 0.98000;
    protected $min_send_amount      = 1;
    protected $max_send_amount      = 100;
    protected $min_receive_amount   = 1;
    protected $max_receive_amount   = 100;


    /**
     * @param Currency $currencyModel
     * @param Direction $directionModel
     */
    public function __construct(Currency $currencyModel, Direction $directionModel)
    {
        $this->currencyModel = $currencyModel;
        $this->directionModel = $directionModel;
    }


    /**
     * @throws Exception
     */
    public function CurrencyInsert($data = [])
    {
        if (empty($data)) {
            throw new \Exception('Currency and direction failed');
        }
        try {
            foreach ($data as $datum) {
                $cryptoData = [
                    'title'         => $datum['asset'],
                    'decimal_point' => $this->decimalPoint,
                    'reserve'       => $datum['free'],
                    'symbol'        => $datum['asset'],
                    'slug'          => $datum['asset'],
                    'xml_symbol'    => $datum['asset'],
                ];
                if (!$this->currencyModel->where('symbol', $datum['asset'])->exists()) {
                    $currencyCreate = $this->currencyModel->create($cryptoData);
                }
                if (!empty($currencyCreate)) {
                    $receiveCurrency = $this->currencyModel->where('symbol', 'USD')->orWhere('symbol', 'EUR')->pluck('currency_id');
                    foreach ($receiveCurrency as $item) {
                        $directionCreate = [
                            'fk_send_currency_id'    => $currencyCreate->currency_id,
                            'fk_receive_currency_id' => $item,
                            'direction_wage'         => $this->direction_wage,
                            'direction_rate'         => $this->direction_rate,
                            'min_send_amount'        => $this->min_send_amount,
                            'max_send_amount'        => $this->max_send_amount,
                            'min_receive_amount'     => $this->min_receive_amount,
                            'max_receive_amount'     => $this->max_receive_amount,
                        ];
                        $this->directionModel->create($directionCreate);
                    }
                }
            }
        } catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

}