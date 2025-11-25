<?php

namespace X7\Demo;

use Exception;
use X7\Client;
use X7\Constant\ResponseCode;
use X7\Exception\ApiExceptionInterface;
use X7\Exception\BusinessException;
use X7\Exception\ServerRequestException;
use X7\Handler\ArrayParamHandler;
use X7\Model\Server;
use X7\Module\Common\Constant\ApiMethod;
use X7\Module\Common\Request\ServerOpenQueryRequest;
use X7\Module\Common\Response\ServerOpenQueryResponse;
use X7\Request\Server\PostParameterRetriever;
use X7\Response\CommonResponse;
use X7\Utils\Json;

/**
 * 开服查询 demo
 */
class ServerOpenQueryDemo
{
    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function incomingRequest()
    {
        try {
            /** @var \X7\Request\VerifiedRequest $verifiedRequest */
            $verifiedRequest = $this->client->handleRequest(new PostParameterRetriever);

            //限制请求时效，防止重放
            if (time() - strtotime($verifiedRequest->reqTime) >= 300) {
                throw new ServerRequestException("请求超时，请重试");
            }

            switch ($verifiedRequest->apiMethod) {
                case ApiMethod::SERVER_OPEN_QUERY:
                    $response = $this->handleServerOpenQuery($verifiedRequest->bizParams);
                    break;
                default:
                    throw new ServerRequestException("请求apiMethod无效");
            }
        } catch (Exception $e) {
            $response = new CommonResponse;
            if (isset($verifiedRequest)) {
                $response->setApiMethod($verifiedRequest->apiMethod);
            }
            if ($e instanceof ApiExceptionInterface) {
                $response->setRespCode($e->getResponseCode())->setRespMsg($e->getMessage());
            }
        } finally {
            echo Json::encode($this->client->getResponse($response));
        }
    }

    /**
     * 处理开服查询请求
     *
     * @param array $bizParams 原始业务参数，结构与网关回调保持一致
     * @return ServerOpenQueryResponse
     * @throws Exception|ApiExceptionInterface
     */
    private function handleServerOpenQuery($bizParams)
    {
        //使用请求对象统一完成字段提取、必填校验
        $request = ServerOpenQueryRequest::make(new ArrayParamHandler($bizParams));
        $response = new ServerOpenQueryResponse;

        //将ISO8601时间转为时间戳，便于后续区间对比
        $startTimestamp = $this->parseIso8601Timestamp($request->startTime, 'startTime');
        $endTimestamp = $this->parseIso8601Timestamp($request->endTime, 'endTime');

        if ($startTimestamp !== null && $endTimestamp !== null && $startTimestamp > $endTimestamp) {
            throw new BusinessException("startTime不能大于endTime");
        }

        //此处仅提供示例数据，真实环境可以替换为数据库/服务查询结果
        $demoServers = [
            [
                "serverId" => "S1", //区服id
                "serverTime" => "2022-05-20T22:22:22+0800", //开服时间，格式使用ISO8601规范
                "serverName" => "一区 苍穹之上", //区服名称，可为空
                "apiServer" => "S1_API" //api区服，如不为空，角色信息查询等接口会优先使用此值作为serverId进行调用查询
            ],
            [
                "serverId" => "S2",
                "serverTime" => "2022-06-02T10:00:00+0800",
                "serverName" => "二区 烈焰之心",
                "apiServer" => ""
            ],
            [
                "serverId" => "S3",
                "serverTime" => "2022-06-15T09:30:00+0800",
                "serverName" => "",
                "apiServer" => "S3_API"
            ],
        ];

        foreach ($demoServers as $demoServer) {
            $serverTimestamp = strtotime($demoServer["serverTime"]);
            if ($serverTimestamp === false) {
                continue;
            }

            if (
                ($startTimestamp === null || $serverTimestamp >= $startTimestamp) &&
                ($endTimestamp === null || $serverTimestamp <= $endTimestamp)
            ) {
                $response->appendServer(Server::make($demoServer));
            }
        }

        return $response
            ->setRespCode(ResponseCode::SUCCESS)
            ->setRespMsg("查询开服信息成功");
    }

    /**
     * 将 ISO8601 时间字符串转换为时间戳并校验格式
     *
     * @param string $value
     * @param string $field
     * @return int|null
     * @throws BusinessException
     */
    private function parseIso8601Timestamp($value, $field)
    {
        if ($value === '' || $value === null) {
            return null;
        }
        $timestamp = strtotime($value);
        if ($timestamp === false) {
            throw new BusinessException("{$field}格式错误，请使用ISO8601规范");
        }
        return $timestamp;
    }
}

