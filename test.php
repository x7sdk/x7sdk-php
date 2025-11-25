<?php

require_once './vendor/autoload.php';

use X7\Client;
use X7\Constant\GameType;
use X7\Constant\OsType;
use X7\Demo\OrderSearchDemo;
use X7\Demo\IpWhiteListQueryDemo;
use X7\Demo\RealNameReportDemo;
use X7\Demo\RoleQueryDemo;
use X7\Demo\RoleReportDemo;
use X7\Demo\ServerNotifyDemo;
use X7\Demo\X7DetectionDemo;
use X7\Demo\X7mallDemo;


$appkey = "0b9ce7b64b02fb17cc948c0b9a6eb462";
$gameRsaPrivateKey = "MIICeAIBADANBgkqhkiG9w0BAQEFAASCAmIwggJeAgEAAoGBAMFEqQmwl+2tyUh9P7a54fe2Qhr4FuhN56KES0v7Wcsp1x5IratBaPCu7wptv1S5mCgmjMPr/vlw6Eq7GVha7fjueRfH8a5g2pWNRcTVBhsjvgpsCFwkIwYSwLx08GzXm8WvERrApXreIcgGYZx4z68z7wmuc/QLsNVPRn5z+D2DAgMBAAECgYEAvIX1PfZ8vOQgzA0g8WUw/ylSImyOK9ySbv0NVfjBBmSx6mCKx9ruOpjppAqZ8FN6EPBJr3OtLDTu4rbPaliId+6SHObBBcHRY/E60+GVPftm+uGIeqCWbmuwL9/GavXLmgizTFi1Fmt05McyZpraG+mLqZSUZ5l2SrWe0D9j3UECQQD0IUChK1N/4xYdW0GQ0N6t2A1omUr97RJDZm8P59zHZF4wEHgGvI+Ii8j+Hnw/T5ZkzVylVTbl0p/ozqzkjUMFAkEAyqpRv/q/deffiOi69Z5572QnM+xHemWwp2jM5fQMeXXoQ4Wxcl4cULQDVzv9msp9UtVagoNAT+AtmY82pCD05wJBAM2BMGZ7kk6VWohbyVWefdTZinACmp4mcrlKATPiendeherv8hm5oRnQkeFYyD6DQJaaSOLkWNId+35+fAvo3gECQQCPJjy2INQp4Q1odBLSuQyhxhlWuJdIYhmkNgc8ieRhyqGzR/SttsHDU1Nkw6//LPXWk3Lp6vF7Ofqbk6fhyJGTAkAznFBvgD8KVp3XIKJ4Aydi+h6D1mrNb1j7WSYRbwhNtUa1Pc1TGR+J/M2QNcVKPdgc9zoKZk8p3xgmgLGOjRia";
$x7PublicKey = "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDBRKkJsJftrclIfT+2ueH3tkIa+BboTeeihEtL+1nLKdceSK2rQWjwru8Kbb9UuZgoJozD6/75cOhKuxlYWu347nkXx/GuYNqVjUXE1QYbI74KbAhcJCMGEsC8dPBs15vFrxEawKV63iHIBmGceM+vM+8JrnP0C7DVT0Z+c/g9gwIDAQAB";
$gameType = GameType::CLIENT;
// $osType = OsType::ANDROID;
$osType = OsType::ANDROID;

$client = new Client($appkey, $gameRsaPrivateKey, $x7PublicKey, $gameType, $osType);

// 小7商城
// $demo = new X7mallDemo($client);
// $demo->incomingRequest();
// $demo->sendMallEntryRequest();


// 小7检测
// $demo = new X7DetectionDemo($client);
// $demo->sendMessageDetectRequest();


// 角色查询V2
// $demo = new RoleQueryDemo($client);
// $demo->incomingRequest();


// IP 白名单查询
// $demo = new IpWhiteListQueryDemo($client);
// $demo->sendIpWhiteListQueryRequest();

// 角色信息上报
// $demo = new RoleReportDemo($client);
// $demo->sendRoleReportRequest();

// 实名上报数据解密
// $demo = new RealNameReportDemo($client);
// $demo->getUserRealNameInfo();

// 开服通知
// $demo = new ServerNotifyDemo($client);
// $demo->sendServerNotifyRequest();

// 订单查询
// $demo = new OrderSearchDemo($client);
// $demo->sendOrderSearchRequest();