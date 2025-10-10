<?php

namespace X7\Utils;

/**
 * 验签工具
 */
class Signature
{

    public static function sign($content, $rsaPrivateKey, $algo = OPENSSL_ALGO_SHA256)
    {
        $formatPrivateKey = self::formatRsaPrivateKey($rsaPrivateKey);
        openssl_sign($content, $signature, $formatPrivateKey, $algo);
        return base64_encode($signature);
    }

    public static function verify($content, $signature, $rsaPublicKey, $algo = OPENSSL_ALGO_SHA256)
    {
        $rawSignature = base64_decode($signature);
        $formatPublicKey = self::formatRsaPublicKey($rsaPublicKey);
        return openssl_verify($content, $rawSignature, $formatPublicKey, $algo);
    }

    public static function genPayload($apiMethod, $appkey, $datetime, $body, $gameType, $method = "POST")
    {
        $payload = $method . " " . $apiMethod . "@" . $appkey . "#" .$gameType . "." 
            . $datetime . "\n\n" . $body;
        return $payload;
    }


    public static function formatRsaPublicKey($publicKey)
    {
        return "-----BEGIN PUBLIC KEY-----\r\n" . wordwrap($publicKey, 64, "\r\n", TRUE) . "\r\n-----END PUBLIC KEY-----";
    }

    public static function formatRsaPrivateKey($privateKey)
    {
        return "-----BEGIN RSA PRIVATE KEY-----\r\n" . wordwrap($privateKey, 64, "\r\n", TRUE) . "\r\n-----END RSA PRIVATE KEY-----";
    }

    /**
     * 数据加密
     * @param $payload
     * @param $rsaPrivateKey
     * @return string
     */
    public static function encrypt($payload, $rsaPrivateKey)
    {
        $encrypted = '';
        $rsaPrivateKey = self::formatRsaPrivateKey($rsaPrivateKey);
        $priId = openssl_get_privatekey($rsaPrivateKey);
        $keyLen = openssl_pkey_get_details($priId)['bits'];
        $partLen = $keyLen / 8 - 11;
        $parts = str_split($payload, $partLen);
        foreach ($parts as $part) {
            $encryptedTemp = '';
            openssl_private_encrypt($part, $encryptedTemp, $rsaPrivateKey);
            $encrypted .= $encryptedTemp;
        }
        return base64_encode($encrypted);
    }

    /**
     * 数据解密
     * @param $encrypt
     * @param $rsaPublicKey
     * @return string
     */
    public static function decrypt($encrypt, $rsaPublicKey)
    {
        $str = str_replace(' ', '+', $encrypt);
        $decrypted = "";
        $rsaPublicKey = self::formatRsaPublicKey($rsaPublicKey);
        $priId = openssl_get_publickey($rsaPublicKey);
        $keyLen = openssl_pkey_get_details($priId)['bits'];
        $partLen = $keyLen / 8;
        $base64Decoded = base64_decode($str);
        $parts = str_split($base64Decoded, $partLen);
        foreach ($parts as $part) {
            $decryptedTemp = '';
            openssl_public_decrypt($part, $decryptedTemp, $rsaPublicKey);
            $decrypted .= $decryptedTemp;
        }
        return $decrypted;
    }
}