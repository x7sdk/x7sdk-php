<?php

namespace X7\Module\Common\Request;

use X7\Exception\ParameterException;
use X7\Handler\ParamHandlerInterface;
use X7\Module\Common\Constant\ApiMethod;
use X7\Request\RequestInterface;

class OrderSearchRequest implements RequestInterface
{
    /**
     * 开始时间 格式使用ISO8601规范，示例：2022-05-20T22:22:22+0800
     * 
     * @var string
     */
    public $startTime = "";

    /**
     * 截止时间 格式使用ISO8601规范，示例：2022-05-20T22:22:22+0800
     *
     * @var string
     */
    public $endTime = "";


    public function getApiMethod()
    {
        return ApiMethod::ORDER_QUERY;
    }

    public static function make(ParamHandlerInterface $paramHandler)
    {
        $startTime = $paramHandler->getInputValue("startTime");
        $endTime = $paramHandler->getInputValue("endTime");
        if (empty($startTime) || empty($endTime)) {
            throw new ParameterException("startTime和endTime不能为空");
        }
        $request = new self;
        $request->startTime = $startTime;
        $request->endTime = $endTime;
        return $request;
    }
}