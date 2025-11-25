<?php

namespace X7\Module\Common\Request;

use X7\Exception\ParameterException;
use X7\Handler\ParamHandlerInterface;
use X7\Module\Common\Constant\ApiMethod;
use X7\Request\RequestInterface;

class ServerOpenQueryRequest implements RequestInterface
{
    /**
     * 开服查询起始时间（ISO8601），允许为空字符串表示不限制
     *
     * @var string
     */
    public $startTime = '';

    /**
     * 开服查询截止时间（ISO8601），允许为空字符串表示不限制
     *
     * @var string
     */
    public $endTime = '';

    public function getApiMethod()
    {
        return ApiMethod::SERVER_OPEN_QUERY;
    }

    public static function make(ParamHandlerInterface $paramHandler)
    {
        $startTime = $paramHandler->getInputValue('startTime');
        $endTime = $paramHandler->getInputValue('endTime');

        if ($startTime === null) {
            throw new ParameterException("startTime不能为空");
        }
        if ($endTime === null) {
            throw new ParameterException("endTime不能为空");
        }

        $request = new self;
        $request->startTime = (string)$startTime;
        $request->endTime = (string)$endTime;
        return $request;
    }
}

