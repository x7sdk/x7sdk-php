<?php

require_once './vendor/autoload.php';

use X7\Client;
use X7\Constant\GameType;
use X7\Constant\OsType;
use X7\Demo\IpWhiteListQueryDemo;
use X7\Demo\RoleQueryDemo;
use X7\Demo\RoleReportDemo;
use X7\Demo\X7DetectionDemo;
use X7\Demo\X7mallDemo;


$appkey = "";
$gameRsaPrivateKey = "";
$x7PublicKey = "";
$gameType = GameType::CLIENT;
// $osType = OsType::ANDROID;
$osType = "";


$client = new Client($appkey, $gameRsaPrivateKey, $x7PublicKey, $gameType, $osType);

// 小7商城
$demo = new X7mallDemo($client);
// $demo->incomingRequest();
$demo->sendMallEntryRequest();


// 小7检测
// $demo = new X7DetectionDemo($client);
// $demo->sendMessageDetectRequest();


// 角色查询V2
// $demo = new RoleQueryDemo($client);
// $demo->incomingRequest();


// IP 白名单查询
// $demo = new IpWhiteListQueryDemo($client);
// $demo->sendIpWhiteListQueryRequest();

// 角色上报
// $demo = new RoleReportDemo($client);
// $demo->sendRoleReportRequest();