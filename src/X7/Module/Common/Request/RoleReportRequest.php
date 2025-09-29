<?php

namespace X7\Module\Common\Request;

use RuntimeException;
use X7\Handler\ParamHandlerInterface;
use X7\Module\Common\Constant\ApiMethod;
use X7\Request\RequestInterface;

/**
 * 角色信息上报请求
 */
class RoleReportRequest implements RequestInterface
{
    /**
     * 游戏角色
     * 
     * @var string
     */
    public $role = [];

    public function getApiMethod()
    {
        return ApiMethod::ROLE_REPORT;
    }

    public static function make(ParamHandlerInterface $paramHandler)
    {
        $role = $paramHandler->getInputValue("role");

        if (empty($role) || !is_object($role)) {
            throw new RuntimeException("角色信息参数有误");
        }

        if (empty($role->roleId) || !is_string($role->roleId)) {
            throw new RuntimeException("游戏角色ID参数有误");
        }

        if (empty($role->guid) || !is_string($role->guid)) {
            throw new RuntimeException("小7小号ID参数有误");
        }

        if (empty($role->roleName) || !is_string($role->roleName)) {
            throw new RuntimeException("角色名称参数有误");
        }

        if (empty($role->serverId) || !is_string($role->serverId)) {
            throw new RuntimeException("角色所属区服ID参数有误");
        }

        if (empty($role->serverName) || !is_string($role->serverName)) {
            throw new RuntimeException("角色所属区服名称参数有误");
        }

        $request = new self;
        foreach ($role as $key => $value) {
            if (!empty($value)) {
                $request->role[$key] = $value;
            }
        }

        return $request;
    }
}
