<?php

namespace X7\Module\Common\Response;

use Exception;
use RuntimeException;
use X7\Module\Common\Constant\ApiMethod;
use X7\Module\Common\Request\RealNameReportRequest;
use X7\Response\CommonResponse;
use X7\Utils\Signature;

/**
 * 实名认证上报响应
 */
class RealNameReportResponse extends CommonResponse
{
    protected $decryptData = []; //解密后的报文数据
    protected $apiMethod = ApiMethod::REAL_NAME_REPORT;

    /**
     * 对加密报文进行解密
     */
    public function decryptRealNameInfo(RealNameReportRequest $realNameRequest, string $x7PublicKey)
    {
        try {
            //获取加密报文
            $encryptionData = $realNameRequest->getData();

            //使用RSA解密数据
            $decryptData = Signature::decrypt($encryptionData, $x7PublicKey);

            //将解密后的数据转化为数组的形式
            $decryptDataArray = json_decode($decryptData, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new RuntimeException("解密后的数据不是有效的JSON格式: " . json_last_error_msg());
            }
            
            $this->decryptData = $decryptDataArray;

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
        $decryptDataArray = $this->decryptData;
        return $decryptDataArray;
    }
}