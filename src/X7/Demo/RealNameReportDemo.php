<?php

namespace X7\Demo;

use Exception;
use X7\Client;
use X7\Exception\ServerResponseException;
use X7\Model\RealNameCollection;
use X7\Model\RealNameReportData;
use X7\Utils\Signature;

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

    public function realNameCollectionDecrypt()
    {
        try {
            // 创建实名认证上报数据对象
            $reportData = new RealNameReportData();
            
            // 添加上报数据项
            $collection1 = RealNameCollection::make([
                "no" => 1, //条目编码
                "si" => "2387337ba1e0b0249ba90f55b2ba2521", //游戏内部会话标识
                "bt" => 0, //游戏用户行为类型【0：下线；1：上线】
                "ot" => 1617079205, //行为发生时间戳，单位秒
                "ct" => 0, //用户行为数据上报类型【0：已认证通过用户；2：游客用户】
                "di" => "cf79ae6addba60ad018347359bd144d2", //游客模式设备标识，由游戏运营单位生成，游客用户下必填
                "pi" => "1fffbjzos82bs9cnyj1dna7d6d29zg4esnh99u" //已通过实名认证用户的唯一标识，已认证通过用户必填
            ]);
            
            $collection2 = RealNameCollection::make([
                "no" => 2,
                "si" => "2387337ba1e0b0249ba90f55b2ba2521",
                "bt" => 1,
                "ot" => 1617080905,
                "ct" => 0,
                "di" => "cf79ae6addba60ad018347359bd144d2",
                "pi" => "1fffbjzos82bs9cnyj1dna7d6d29zg4esnh99u"
            ]);
            
            $reportData->addCollection($collection1);
            $reportData->addCollection($collection2);

            //将发送数据转化成json格式
            $testData = json_encode($reportData->toArray(), JSON_UNESCAPED_UNICODE);

            //使用Client中的私钥进行数据加密
            $privateKey = $this->client->getGameRsaPrivateKey();

            //小7进行数据加密（私钥加密）
            $encrypted = Signature::encrypt($testData, $privateKey);

            //使用Client中的公钥进行数据解密
            $publicKey = $this->client->getX7PublicKey();

            //厂商进行数据解密（公钥解密）
            $decrypted = Signature::decrypt($encrypted, $publicKey);

            //将解密后的数据转化为数组的形式
            $decrypted = json_decode($decrypted, true);

            //厂商使用小7上报的数据
            print_r($decrypted);
            
        } catch (Exception $e) {
            // 异常处理
            echo "实名认证数据处理失败: " . $e->getMessage() . "\n";
        }
    }
}