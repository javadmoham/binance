<?php
namespace Javad\Binance;
use GuzzleHttp\Client as Http;
use GuzzleHttp\Exception\GuzzleException;

class BinanceAccountApi
{
    protected $key;          // API key
    protected $secret;       // API secret
    protected $api;          // API base URL
    protected $recvWindow;   // API base URL
    protected $version;      // API version
    protected $timestamp;
    protected $client;

    /**
     * Constructor for BinanceAccountApi
     */
    function __construct()
    {
        $this->key        = config('binance.auth.key');
        $this->secret     = config('binance.auth.secret');
        $this->api        = config('binance.urls.api');
        $this->wapi_url   = config('binance.urls.wapi');
        $this->recvWindow = config('binance.settings.timing');

        $this->timestamp = number_format((microtime(true) * 1000), 0, '.', '');
        $this->client    = new Http();

    }

    /**
     * @throws Exception|GuzzleException
     */
    public function getBalances()
    {
        $b = $this->privateRequest('v3/account');
        return $b['balances'];
    }

    /**
     * Get trades for a specific account and symbol
     * @param string $symbol
     * @param int $limit
     * @return mixed
     * @throws Exception|GuzzleException
     */
    public function getRecentTrades($symbol = 'BNBBTC', $limit = 500)
    {
        $data = [
            'symbol' => $symbol,
            'limit'  => $limit,
        ];

        $b = $this->privateRequest('v3/myTrades', $data);
        return $b;

    }

    /**
     * @throws GuzzleException
     */
    public function getOpenOrders()
    {
        $b = $this->privateRequest('v3/openOrders');
        return $b;

    }

    /**
     * @throws GuzzleException
     */
    public function getAllOrders($symbol = 'BNBUSDT')
    {

        $data = [
            'symbol' => $symbol
        ];
        $b    = $this->privateRequest('v3/allOrders', $data);
        return $b;

    }

    /**
     * @param $url
     * @param array $params
     * @param string $method
     * @return array|mixed
     * @throws GuzzleException
     * @throws Exception
     */
    private function privateRequest($url, $params = [], $method = 'GET')
    {
        try {
            $params['timestamp']  = $this->timestamp;
            $params['recvWindow'] = $this->recvWindow;
            $query                = http_build_query($params, '', '&');
            $signature            = hash_hmac('sha256', $query, $this->secret);

            $responses = $this->client->request(
                $method,
                $this->api . $url . '?' . $query . '&signature=' . $signature,
                [
                    'headers'        => [
                        'X-MBX-APIKEY' => $this->key
                    ],
                    'decode_content' => false
                ]
            );
            $response  = $responses->getBody()->getContents();

            if ($response === false) {
                throw new Exception('error');
            }
            $result = json_decode($response, true);

            if (!is_array($result) || json_last_error()) {
                throw new Exception('JSON decode error');
            }
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * @param $symbol
     * @param $network
     * @return array|mixed
     * @throws Exception
     */
    public function depositAddress($symbol, $network)
    {
        return $this->wapiRequest("/v3/depositAddress.html", ['network' => $network, 'asset' => $symbol]);
    }

    /**
     * @throws GuzzleException
     * @throws Exception
     */
    private function wapiRequest($url, $params = [], $method = 'GET')
    {
        try {
            $params['timestamp']  = $this->timestamp;
            $params['recvWindow'] = $this->recvWindow;
            $query                = http_build_query($params, '', '&');
            $signature            = hash_hmac('sha256', $query, $this->secret);
            $responses            = $this->client->request(
                $method,
                $this->wapi_url . $url . '?' . $query . '&signature=' . $signature,
                [
                    'headers'        => ['X-MBX-APIKEY' => $this->key],
                    'decode_content' => false
                ]
            );
            $response             = $responses->getBody()->getContents();
            if ($response === false) {
                throw new Exception('error');
            }
            $result = json_decode($response, true);
            if (!is_array($result) || json_last_error()) {
                throw new Exception('JSON decode error');
            }
            return $result;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

}
