<?php

namespace X7\Module\Common\Request;

use RuntimeException;
use X7\Handler\ParamHandlerInterface;
use X7\Module\Common\Constant\ApiMethod;
use X7\Request\RequestInterface;

/**
 * 实名认证上报
 */
class RealNameReportRequest implements RequestInterface
{
    //请求报文体加密数据
    public $collections = [];

    public function getApiMethod()
    {
        return ApiMethod::REAL_NAME_REPORT;
    }

    public static function make(ParamHandlerInterface $paramHandler)
    {
        $collections = $paramHandler->getInputValue("collections");

        $request = new self;
        $request->collections = $collections;

        return $request;
    }
}
