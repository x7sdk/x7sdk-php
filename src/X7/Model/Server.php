<?php

namespace X7\Model;

/**
 * 开服信息
 */
class Server extends Model
{
    /**
     * 区服ID
     *
     * @var string
     */
    public $serverId;

    /**
     * 开服时间，ISO8601格式
     *
     * @var string
     */
    public $serverTime;

    /**
     * 区服名称，可选
     *
     * @var string
     */
    public $serverName = '';

    /**
     * API 区服标识，可选
     *
     * @var string
     */
    public $apiServer = '';

    protected static $optionalFields = [
        'serverName',
        'apiServer'
    ];
}

