<?php

namespace X7\Demo;

use Exception;
use X7\Client;
use X7\Exception\ServerResponseException;
use X7\Utils\Signature;

/**
 * 实名认证数据上报demo
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

    public function sendRealNameReportRequest()
    {
        try {
            //小7发送给厂商的数据（测试数据）
            $testData = array(
                "collections" =>
                    array(
                        array(
                            "no" => 1, //条目编码
                            "si" => "2387337ba1e0b0249ba90f55b2ba2521", //游戏内部会话标识
                            "bt" => 0, //游戏用户行为类型【0：下线；1：上线】
                            "ot" => 1617079205, //行为发生时间戳，单位秒
                            "ct" => 0, //用户行为数据上报类型【0：已认证通过用户；2：游客用户】
                            "di" => "cf79ae6addba60ad018347359bd144d2", //游客模式设备标识，由游戏运营单位生成，游客用户下必填
                            "pi" => "1fffbjzos82bs9cnyj1dna7d6d29zg4esnh99u" //已通过实名认证用户的唯一标识，已认证通过用户必填
                        ),
                        array(
                            "no" => 2,
                            "si" => "2387337ba1e0b0249ba90f55b2ba2521",
                            "bt" => 1,
                            "ot" => 1617080905,
                            "ct" => 0,
                            "di" => "cf79ae6addba60ad018347359bd144d2",
                            "pi" => "1fffbjzos82bs9cnyj1dna7d6d29zg4esnh99u"
                        ),
                    )
            );

            //将发送数据转化成json格式
            $testData = json_encode($testData, 1);

            //私钥(测试密钥)
            $privateKey = 'MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDDxRpuKIdYQ3lRHlIHJLbwJUKJVSVORZEISw/flJmz1rXATtuiKuPSGmDvDK7qF7J0imX3gF7DPAzckd7jlL9Ri95hCj/Ovclvjq+mgkxA+KQ3JlI5HGaM+WjMi4CVhbnpfcB6t75iQfW4IV556pbQFxPg2+WOfe/IkZiXM7eRYK6KdkfTCGvFK2LJvlImmOWDHP4xVS4EAkINgBGjpYK4IBNO537/3vCykEJ5yz+W29RA9oal6EKFsLbhTdUGYuxIKbGMA8tAki6QfqzLq1WgrmOaM2cWwKtZuR3rwfq2yb10Y9xQyA1bF5qFT/y1I61f3gBpN9Thynzjpift0fglAgMBAAECggEAIVoJ96xl6m6MU3qD5P2nQOBIJpdf5KbLX4tSJ/fr+4xfqGSG3GjMKTYfP3p8rhrdZydQ2cp/2mj3k/gx7bmgombeus+BMVp538yCNi7KiOMTLuYTafFhszCmXvqBLHf8xT+MNBvrjlfIYdclfkWt7cOQumUcBZuE5zmOsmu4IUb4ArjKsEmGDqdsp3fCESzbMWqBinvOmdUy+3VbBTpSjU/PDWCd/OgnTHpwPY7O9T7zSo8grkkWyq79W5kz7PLXdtqt1DNChUjHHv+ANM3T5L127BlHDskyG24AGrDzLmCmNQab4qFtOjPtHdsXsQm8cllgzD4lvP6ThuAG8DK4IQKBgQDnoCY8CLc2kUNyibdaA5N7y4xaY9vm1t6jKf37fOS069GkUNfOb8r+Pxp70UAKzMBWZ4iVlDbEh3FU0jveYutsUUbjEB4qI19/jvUHahKzaE9DCK3HkGvjT3NkQmZ+LslS/CxJtyZl+mN8/Ur6OA7p/l8BuJMVMXY+G7mQRZVtzQKBgQDYXwZX712DP5DTLcoUwOM9mIa8UFIFoZN+lwKLq8c0wbpZ3uicU90YwCPVvuATp/fwjOgOEId8HkLeBXkbqkJRimI0y4bTPzHNk0JDlTso79ERcglA9wU4j3C6OArB0Id/u2cVSex/JW3arQt2jRk5JCSDtWn7k1cB9qPvckUbuQKBgA3nYSQtacIOyjuv5J+0oz/FIjGy2Npsf4TP2n0kLB5oIXd5mtq7fzXv18ki8HM1gz4sjNhdw0Pc1YK/8/QPgA5KerTanNTutqbTkAXX6jN2yXs+pB/cnX1RoZ2dFsXwTQl8NbRfGCD6/Mnd8og+oTaOnGlgCQQ2qeBkjakJZETpAoGBAIu/FAHHf8Y9T/SVJmexDRPDZ4JI/jDU4sZoEiTTlZ3lYc6ZwfL1118c+ggbd+46FlEvMNGkq1zmzplHP6k2lg7EKhmfOj1GG4yDB9FOmR8fhRCXbpKe+KhHPK+JcqkrXdiJ2VJOpIiaTBFoona3OwtE5LCMgx8RUqjZ+5ezXh9BAoGBAIz5//GXs1kJoGQatr0rvE4CvVLVbKHaVaXy7MAcp4uya3g1cZh3Swje8e4RD6UfiKmx+aPETfw9IkXbrPTYmXCNDx5bSbbPL+WMY8c7F7K0krOfl8Vtzg5cCfo45+IsLCM16sDT0MhLCPUMWj0kcd4bKcAc3CENaL3U03oLE58r';

            //小7进行数据加密（私钥加密）
            $encrypted = Signature::encrypt($testData, $privateKey);

            //公钥(测试密钥)
            $publicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAw8UabiiHWEN5UR5SByS28CVCiVUlTkWRCEsP35SZs9a1wE7boirj0hpg7wyu6heydIpl94BewzwM3JHe45S/UYveYQo/zr3Jb46vpoJMQPikNyZSORxmjPlozIuAlYW56X3Aere+YkH1uCFeeeqW0BcT4Nvljn3vyJGYlzO3kWCuinZH0whrxStiyb5SJpjlgxz+MVUuBAJCDYARo6WCuCATTud+/97wspBCecs/ltvUQPaGpehChbC24U3VBmLsSCmxjAPLQJIukH6sy6tVoK5jmjNnFsCrWbkd68H6tsm9dGPcUMgNWxeahU/8tSOtX94AaTfU4cp846Yn7dH4JQIDAQAB';

            //厂商进行数据解密（公钥解密）
            $decrypted = Signature::decrypt($encrypted, $publicKey);

            //将解密后的数据转化为数组的形式
            $decrypted = json_decode($decrypted, true);

            //厂商使用小7上报的数据
            
        } catch (Exception $e) {
            // 异常处理
            if ($e instanceof ServerResponseException) {
                echo $e->getContext();
            }
            echo $e->getMessage();
        }
    }
}