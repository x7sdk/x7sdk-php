<?php

namespace X7\Module\Common\Request;

use X7\Exception\ParameterException;
use X7\Handler\ParamHandlerInterface;
use X7\Module\Common\Constant\ApiMethod;
use X7\Request\RequestInterface;

/**
 * 开服通知请求
 */
class ServerNotifyRequest implements RequestInterface
{
    /**
     * 区服信息
     * 
     * @var string
     */
    public $serverList = [];

    public function getApiMethod()
    {
        return ApiMethod::SERVER_NOTIFY;
    }

    public static function make(ParamHandlerInterface $paramHandler)
    {
        $serverList = $paramHandler->getInputValue("serverList");

        if (empty($serverList)) {
            throw new ParameterException("serverList数据不能为空");
        }

        if (!is_array($serverList)) {
            throw new ParameterException("serverList数据类型有误");
        }

        $request = new self;
        $request->serverList = $serverList;

        return $request;
    }
}
