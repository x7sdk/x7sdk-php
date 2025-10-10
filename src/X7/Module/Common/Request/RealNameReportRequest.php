<?php

namespace X7\Module\Common\Request;

use X7\Handler\ParamHandlerInterface;
use X7\Module\Common\Constant\ApiMethod;
use X7\Module\Common\Constant\OsType;
use X7\Request\RequestInterface;
use X7\Utils\Signature;

/**
 * 实名认证上报请求
 */
class RealNameReportRequest implements RequestInterface
{
    
    protected $timestamps = ""; //请求报文中的调用时间，单位毫秒
    protected $appkey = ""; //请求报文中的appkey，游戏方在小7平台的唯一标识
    protected $data = ""; //请求报文体加密数据
    protected $osType = ""; //请求报文中的系统类型，ios 或 android，游戏双端使用相同appkey对接时，此参数必传
    protected $decryptData = []; //解密后的data报文数据

    public function getApiMethod()
    {
        return ApiMethod::REAL_NAME_REPORT;
    }

    public static function make(ParamHandlerInterface $paramHandler)
    {
        $timestamps = $paramHandler->getInputValue("timestamps");
        $appkey = $paramHandler->getInputValue("appkey");
        $data = $paramHandler->getInputValue("data");
        $osType = $paramHandler->getInputValue("osType");

        if (empty($timestamps) || !is_string($timestamps)) {
            throw new ParameterException("timestamps参数有误");
        }
        if (empty($appkey) || !is_string($appkey)) {
            throw new ParameterException("appkey参数有误");
        }
        if (empty($data) || !is_string($data)) {
            throw new ParameterException("data参数有误");
        }
        if (!empty($osType) && !in_array($osType, [OsType::IOS, OsType::ANDROID])) {
            throw new ParameterException("osType参数有误");
        }

        $request = new self;
        $request->timestamps = $timestamps;
        $request->appkey = $appkey;
        $request->data = $data;
        $request->osType = $osType;

        return $request;
    }

    /**
     * 对加密报文进行解密
     */
    public function decryptRealNameInfo(string $x7PublicKey)
    {
        try {
            //获取加密报文
            $encryptionData = $this->data;

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
     * 获取解密后的data报文数据
     */
    public function getDecryptData()
    {
        $decryptDataArray = $this->decryptData;
        return $decryptDataArray;
    }
}
