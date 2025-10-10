<?php

namespace X7\Demo;

use Exception;
use X7\Client;
use X7\Handler\ArrayParamHandler;
use X7\Module\Common\Request\RealNameReportRequest;

/**
 * 解密实名上报demo
 */
class RealNameReportDemo
{

    /**
     * @var Client
     */
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * 获取用户实名上报解密数据
     */
    public function getUserRealNameInfo()
    {
        try {
            //小7提供的请求报文体明文数据（测试数据）
            $requestData = [
                "timestamps" => "1760011378000", //调用时间，单位毫秒
                "appkey" => "dszce7b64b0234dccc948c0bdsxeb462", //游戏方在小7平台的唯一标识
                "data" => "eLIR9mY4oH9Wo+E8TR5RicRdj+uz1pR4axwanrbmDFuvHhvugCFSVjMEMX1Qf4nYpJpCfSX6B4+qccKIsCDFhbUOtsH11oOP7y+WZ2KXrwKK0EwuuQnhOAq5CwEsqmX2BICnZE9xLJn+kB0hnGypDfuxV/gZKubgamKNjQ/rDnWbB5z/436dwcBK6w2yBo+Sg2CmG/wJVsYyv9sRm06iD6+iy6crg6JCI5y1QRLxCX/LAZnWEyGFA+JJYIyDH7D1lOeE93Fcv9q3a2SSG3uHKeOg7C3rC8C2lZqmMLco1bCF72xRJgbWZkMUWdRo1j0xqy3/2XL0W3KZsZ2PCyHFJTm8BrN6kH85RqFWzICY3HylIQhIL6A6Zu+/4nnVWkZJHbO9WeNEVMJKV8i4h2SYMfTgM48bgnc7zIuOB8GPc4sOt5bCN6FAINv2W7sRyUXDchSiwu7Ve1Pr69iCKR0L8WI2v4UYJUp1FMfNlStHbl4Y/J91wwW1VylfgWLvZ+MwG8nyIbhRrVcHWuWPbgiBv47EawaNxd7HJoI5VlkKjSR9rvhftY2RvwMsE7Y0DfWCvy/zowOzcsAJmxZB7antcIpWO3sBRFA3ASmldU98GIbJz2KonE+HqLtk4Uip3bXUbobvtklPRpCCcLEFASX3bJsCq1Ls2Wokiqy+22QM4Cs=", //请求报文体加密数据
                "osType" => "android" //系统类型
            ];
            
            //用户实名上报请求参数
            $realNameReportRequest = RealNameReportRequest::make(new ArrayParamHandler($requestData));

            //小7提供的公钥
            $x7PublicKey = $this->client->getX7PublicKey(); 

            //厂商进行数据解密
            $realNameReportRequest->decryptRealNameInfo($x7PublicKey);

            //获取解密后的data报文数据
            $decryptData = $realNameReportRequest->getDecryptData();
            
            print_r($decryptData);
        } catch (Exception $e) {
            // 异常处理
            echo "实名认证数据处理失败: " . $e->getMessage() . "\n";
        }
    }
}