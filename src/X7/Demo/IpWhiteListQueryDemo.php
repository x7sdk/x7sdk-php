<?php

namespace X7\Demo;

use Exception;
use X7\Client;
use X7\Constant\ResponseCode;
use X7\Exception\ServerResponseException;
use X7\Handler\ArrayParamHandler;
use X7\Module\Common\Constant\IpWhiteListQueryType;
use X7\Module\Common\Request\IpWhiteListQueryRequest;
use X7\Module\Common\Response\IpWhiteListQueryResponse;

/**
 * IP白名单查询 demo
 */
class IpWhiteListQueryDemo
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

    public function sendIpWhiteListQueryRequest()
    {
        try {
            $bizParams = [
                "ipType" => IpWhiteListQueryType::CLIENT, //查询类型，支持类型：client表示用户ip
            ];

            //IP白名单查询请求参数
            $ipWhiteListQueryRequest = IpWhiteListQueryRequest::make(new ArrayParamHandler($bizParams));
            
            //发起请求
            $verifiedResponse = $this->client->request($ipWhiteListQueryRequest, $this->testRequestUrl);
            
            //请求响应验证
            $response = (new IpWhiteListQueryResponse)->validate(new ArrayParamHandler($verifiedResponse->bizResp));
            
            //校验请求响应状态
            if ($response->respCode != ResponseCode::SUCCESS) {
                //请求失败处理...
            }

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