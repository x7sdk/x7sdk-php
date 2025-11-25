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
     * 用户实名上报
     */
    const REAL_NAME_REPORT = "common.realNameReport";
    
    /**
     * 开服通知
     */
    const SERVER_NOTIFY = "common.serverNotify";

    /**
     * 订单查询
     */
    const ORDER_QUERY = "common.orderQuery";
}