<?php

namespace X7\Module\Common\Constant;

use X7\Constant\AbstractConstant;

class ApiMethod extends AbstractConstant
{
    /**
     * 角色查询
     */
    const ROLE_QUERY = "common.roleQuery";

    /**
     * IP白名单查询
     */
    const IP_WHITELIST_QUERY = "common.ipWhiteListQuery";

    /**
     * 角色信息上报
     */
    const ROLE_REPORT = "common.roleReport";

    /**
     * 开服信息查询
     */
    const SERVER_OPEN_QUERY = "common.serverOpenQuery";
}