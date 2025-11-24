<?php

namespace X7\Demo;

use Exception;
use X7\Client;
use X7\Constant\ResponseCode;
use X7\Exception\ServerResponseException;
use X7\Handler\ArrayParamHandler;
use X7\Model\Server;
use X7\Module\Common\Request\ServerNotifyRequest;
use X7\Module\Common\Response\ServerNotifyResponse;

/**
 * 开服通知 demo
 */
class ServerNotifyDemo
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

    public function sendServerNotifyRequest()
    {
        try {
            $bizParams = [
                "serverList" => []
            ];

            //开服信息列表
            $serverList = [
                [
                    "serverId" => "1", //区服ID（区服编号）
                    "serverTime" => "2022-05-20T22:22:22+0800", //开服时间，格式使用ISO8601规范
                    "serverName" => "区服名称", //区服名称，可为空
                    "apiServer" => "1", //api区服，如不为空，角色信息查询等接口会优先使用此值作为serverId进行调用查询
                ],
                [
                    "serverId" => "2", //区服ID（区服编号）
                    "serverTime" => "2022-05-20T22:22:22+0800", //开服时间，格式使用ISO8601规范
                    "serverName" => "区服名称", //区服名称，可为空
                    "apiServer" => "", //api区服，如不为空，角色信息查询等接口会优先使用此值作为serverId进行调用查询
                ]
            ];

            foreach ($serverList as $serverData) {
                $bizParams["serverList"][] = Server::make($serverData);
            }

            //构造开服通知请求参数
            $serverNotifyRequest = ServerNotifyRequest::make(new ArrayParamHandler($bizParams));

            //发起请求
            $verifiedResponse = $this->client->request($serverNotifyRequest, $this->testRequestUrl);

            //请求响应验证
            $response = (new ServerNotifyResponse)->validate(new ArrayParamHandler($verifiedResponse->bizResp));

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