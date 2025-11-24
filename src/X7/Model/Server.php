<?php

namespace X7\Model;

/**
 * 开服信息
 */
class Server extends Model
{
    /**
     * 区服ID（区服编号）
     * 
     * @var string
     */
    public $serverId;

    /**
     * 开服时间
     * 
     * @var string
     */
    public $serverTime;

    /**
     * 区服名称
     * 
     * @var string
     */
    public $serverName;

    /**
     * api区服
     * 
     * @var string
     */
    public $apiServer;

    /**
     * 可选参数
     *
     * @var array
     */
    protected static $optionalFields = [
        'serverName',
        'apiServer'
    ];
}