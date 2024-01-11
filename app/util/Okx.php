<?php

namespace app\util;

use DateTime;
use GuzzleHttp\Client;

class Okx
{
    private $client;

    public function __construct()
    {
        $api_key = "f5890ab2-a9c8-45bf-a91d-6010be64efbe";
        $secret_key = "ADC1875DA3B14F1BF650EF29BF652E43";
        $passphrase = "XQBxqb123@";

        // 设置时区为UTC
        date_default_timezone_set('UTC');

        // 获取当前时间的 DateTime 对象
        $dateTime = new DateTime();

        // 格式化时间戳为指定的格式（ISO 8601）
        $timestamp = $dateTime->format('Y-m-d\TH:i:s.u\Z');

        $url = "";

        $body = "";

        $string = $timestamp . "GET" . $url . $body;

        $signature = base64_encode(hash_hmac('sha256', $string, $secret_key));

        $headers = [
            "OK-ACCESS-KEY" => $api_key,

            "OK-ACCESS-SIGN" => $signature,

            "OK-ACCESS-TIMESTAMP" => $timestamp,

            "OK-ACCESS-PASSPHRASE" => $passphrase
        ];

        $this->client = new Client([
            "proxy" => "http://127.0.0.1:23457",
            "verify" => false,
            "headers" => $headers
        ]);
    }

    public function getPrice($type)
    {
        $style = strtoupper($type);
        
        $url = "https://www.okx.com/api/v5/public/mark-price?instType=SWAP&instId={$style}-USDT-SWAP";

        $res = $this->client->get($url)->getBody()->getContents();
        

        return json_decode($res)->data[0]->markPx;
    }
}

