<?php

namespace X7\Module\Common\Response;

use X7\Module\Common\Constant\ApiMethod;
use X7\Response\CommonResponse;

/**
 * 角色信息上报响应
 */
class RoleReportResponse extends CommonResponse
{
    protected $apiMethod = ApiMethod::ROLE_REPORT;
}
