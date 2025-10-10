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
    protected $data = []; //解密后的报文数据
    protected $apiMethod = ApiMethod::REAL_NAME_REPORT;

    /**
     * 对加密报文进行解密
     */
    public function decryptRealNameInfo(RealNameReportRequest $realNameRequest, string $x7PublicKey)
    {
        try {
            //获取加密报文
            $encryptionData = $realNameRequest->getEncryptionData(); //加密报文

            //使用RSA解密数据
            $decryptData = Signature::decrypt($encryptionData, $x7PublicKey);

            //将解密后的数据转化为数组的形式
            $decryptDataArray = json_decode($decryptData, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException("解密后的数据不是有效的JSON格式: " . json_last_error_msg());
            }
            
            $this->data = $decryptDataArray;

            return $this;
        } catch (Exception $e) {
            throw new RuntimeException("实名信息解密失败: " . $e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * 获取解密后的报文数据
     */
    public function getDecryptData()
    {
        $decryptDataArray = $this->data;
        return $decryptDataArray;
    }
}