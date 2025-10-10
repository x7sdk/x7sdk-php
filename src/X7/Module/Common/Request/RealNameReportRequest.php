<?php

namespace X7\Module\Common\Request;

use X7\Handler\ParamHandlerInterface;
use X7\Module\Common\Constant\ApiMethod;
use X7\Request\RequestInterface;

/**
 * 实名认证上报
 */
class RealNameReportRequest implements RequestInterface
{
    //请求报文体加密数据
    protected $data = "";

    public function getApiMethod()
    {
        return ApiMethod::REAL_NAME_REPORT;
    }

    public static function make(ParamHandlerInterface $paramHandler)
    {
        $data = $paramHandler->getInputValue("data");

        $request = new self;
        $request->data = $data;

        return $request;
    }

    /**
     * 获取请求报文体加密数据
     */
    public function getEncryptionData()
    {
        $encryptionData = $this->data;
        return $encryptionData;
    }
}
