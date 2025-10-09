<?php

namespace X7\Module\Common\Response;

use Exception;
use RuntimeException;
use X7\Client;
use X7\Module\Common\Constant\ApiMethod;
use X7\Module\Common\Request\RealNameReportRequest;
use X7\Response\CommonResponse;
use X7\Utils\Signature;

class RealNameReportResponse extends CommonResponse
{
    //请求报文体解密数据
    public $collections = [];
    protected $apiMethod = ApiMethod::REAL_NAME_REPORT;

    /**
     * 对加密报文进行解密
     */
    public function getRealNameInfo(RealNameReportRequest $realNameRequest, Client $client)
    {
        try {
            $encrypted = $realNameRequest->collections; //加密报文
            $x7PublicKey = $client->getX7PublicKey(); //小7提供的公钥

            //使用RSA解密数据
            $decrypted = Signature::decrypt($encrypted, $x7PublicKey);

            //将解密后的数据转化为数组的形式
            $decrypted = json_decode($decrypted, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException("解密后的数据不是有效的JSON格式: " . json_last_error_msg());
            }
            
            $this->collections = $decrypted;

            return $this;
        } catch (Exception $e) {
            throw new RuntimeException("实名信息解密失败: " . $e->getMessage(), $e->getCode(), $e);
        }
    }
}