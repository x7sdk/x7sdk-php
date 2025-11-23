<?php

namespace X7\Demo;

use Exception;
use X7\Client;
use X7\Constant\ResponseCode;
use X7\Exception\ServerResponseException;
use X7\Handler\ArrayParamHandler;
use X7\Module\Common\Request\GameOrderSearchRequest;
use X7\Module\Common\Response\GameOrderSearchResponse;

/**
 * 订单查询 demo
 */
class GameOrderSearchDemo
{
   /**
     * @var Client
     */
    protected $client;

    protected $requestUrl = "https://api.x7sy.com/vendorApi/gateway";

    protected $testRequestUrl = "https://api.x7sy.com/vendorApi/sample";


    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * 发送订单查询请求
     * 
     */
    public function sendGameOrderSearchRequest()
    {
        try {
            $gameOrderSearchRequest = GameOrderSearchRequest::make(new ArrayParamHandler([
                "startTime" => "2024-11-23 00:00:00",
                "endTime" => "2025-11-23 23:59:59"
            ]));

            $verifiedResponse = $this->client->request($gameOrderSearchRequest, $this->testRequestUrl);

            $response = (new GameOrderSearchResponse)->validate(new ArrayParamHandler($verifiedResponse->bizResp));

            //校验请求响应状态
            if ($response->respCode != ResponseCode::SUCCESS) {
                //do something
            }

            $response->orderList;

            var_dump($response);
        } catch (Exception $e) {
            //异常处理
            if ($e instanceof ServerResponseException) {
                echo $e->getContext();
            }
            echo $e->getMessage();
        }
    }

}