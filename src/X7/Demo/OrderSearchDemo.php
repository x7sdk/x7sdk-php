<?php

namespace X7\Demo;

use Exception;
use X7\Client;
use X7\Constant\ResponseCode;
use X7\Exception\ServerResponseException;
use X7\Handler\ArrayParamHandler;
use X7\Module\Common\Request\OrderSearchRequest;
use X7\Module\Common\Response\OrderSearchResponse;

/**
 * 订单查询 demo
 */
class OrderSearchDemo
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
     */
    public function sendOrderSearchRequest()
    {
        try {
            $orderSearchRequest = OrderSearchRequest::make(new ArrayParamHandler([
                "startTime" => "2025-11-21T00:00:00+0800",
                "endTime" => "2025-11-21T23:59:59+0800"
            ]));
         
            $verifiedResponse = $this->client->request($orderSearchRequest, $this->testRequestUrl);
            $response = (new OrderSearchResponse)->validate(new ArrayParamHandler($verifiedResponse->bizResp));

            //校验请求响应状态
            if ($response->respCode != ResponseCode::SUCCESS) {
                //do something
            }

            $response->orderList;

            var_dump($response->orderList);
        } catch (Exception $e) {
            //异常处理
            if ($e instanceof ServerResponseException) {
                echo $e->getContext();
            }
            echo $e->getMessage();
        }
    }

}