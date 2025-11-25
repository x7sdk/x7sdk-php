<?php

namespace X7\Module\Common\Response;

use RuntimeException;
use X7\Model\Server;
use X7\Module\Common\Constant\ApiMethod;
use X7\Response\CommonResponse;

class ServerOpenQueryResponse extends CommonResponse
{
    /**
     * 满足时间范围的区服列表
     *
     * @var Server[]
     */
    public $serverList = [];

    protected $apiMethod = ApiMethod::SERVER_OPEN_QUERY;

    public function setServerList($serverList)
    {
        $servers = is_object($serverList) ? [$serverList] : $serverList;
        foreach ($servers as $server) {
            if (!($server instanceof Server)) {
                throw new RuntimeException("serverList数组内元素类型必须为 X7\Model\Server");
            }
        }
        $this->serverList = $servers;
        return $this;
    }

    public function appendServer(Server $server)
    {
        $this->serverList[] = $server;
        return $this;
    }
}

