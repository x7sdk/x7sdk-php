<?php

namespace X7\Demo;

use Exception;
use X7\Client;
use X7\Constant\ResponseCode;
use X7\Exception\ServerResponseException;
use X7\Handler\ArrayParamHandler;
use X7\Model\Role;
use X7\Module\Common\Request\RoleReportRequest;
use X7\Module\Common\Response\RoleReportResponse;

/**
 * 角色信息上报 demo
 */
class RoleReportDemo
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

    public function sendRoleReportRequest()
    {
        try {
            $bizParams = [
                "role" => Role::make([
                    "roleId" => "123456", //游戏角色ID
                    "guid" => "123456", //小7小号ID
                    "roleName" => "角色名称", //角色名称
                    "serverId" => "1", //角色所属区服ID
                    "serverName" => "区服名称", //角色所属区服名称
                    "roleLevel" => "100", //角色等级
                    "roleCE" => "999999", //角色战力
                    "roleStage" => '{"roleName": "我是角色名称"}', //角色自定义数据，支持json格式
                    "roleRechargeAmount" => 5688.66, //角色总充值，精度为小数点后2位
                    "roleGuild" => "公会名称" //角色所属公会
                ])
            ];

            //角色信息上报请求参数
            $roleReportRequest = RoleReportRequest::make(new ArrayParamHandler($bizParams));

            //发起请求
            $verifiedResponse = $this->client->request($roleReportRequest, $this->testRequestUrl);

            //请求响应验证
            $response = (new RoleReportResponse)->validate(new ArrayParamHandler($verifiedResponse->bizResp));

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