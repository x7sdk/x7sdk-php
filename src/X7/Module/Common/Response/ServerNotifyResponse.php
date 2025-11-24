<?php

namespace X7\Module\Common\Response;

use X7\Module\Common\Constant\ApiMethod;
use X7\Response\CommonResponse;

/**
 * 开服通知响应
 */
class ServerNotifyResponse extends CommonResponse
{
    protected $apiMethod = ApiMethod::SERVER_NOTIFY;
}
