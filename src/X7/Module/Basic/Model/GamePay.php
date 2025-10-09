<?php

namespace X7\Module\Basic\Model;

use RuntimeException;
use X7\Model\Model;
use X7\Utils\ParamTool;

class GamePay extends Model
{
    /**
     * @var string
     */
    public $extends_info_data = "";

    /**
     * @var string
     */
    public $game_area = "";

    /**
     * @var string
     */
    public $game_level = "";

    /**
     * @var string
     */
    public $game_orderid = "";

    /**
     * @var string
     */
    public $game_price = "";

    /**
     * @var string
     */
    public $game_role_id = "";

    /**
     * @var string
     */
    public $game_role_name = "";

    /**
     * @var string
     */
    public $game_guid = "";

    /**
     * @var int
     */
    public $notify_id = -1;

    /**
     * @var string
     */
    public $subject = "";

    /**
     * @var string
     */
    public $game_currency = "";

    /**
     * @var string
     */
    public $game_access_version = "";


    public function setGameOrderId($gameOrderId)
    {
        $this->game_orderid = (string)$gameOrderId;
        return $this;
    }

    public function setGameArea($gameArea)
    {
        $this->game_area = $gameArea;
        return $this;
    }

    public function setGameLevel($gameLevel)
    {
        $this->game_level = (string)$gameLevel;
        return $this;
    }

    public function setGamePrice($gamePrice)
    {
        $this->game_price = number_format($gamePrice, 2);
        return $this;
    }

    public function setGameRoleId($roleId)
    {
        $this->game_role_id = (string)$roleId;
        return $this;
    }

    public function setGameRoleName($roleName)
    {
        $this->game_role_name = $roleName;
        return $this;
    }

    public function setGameGuid($guid)
    {
        $this->game_guid = (string)$guid;
        return $this;
    }

    public function setNotifyId($notifyId)
    {
        $this->notify_id = (int)$notifyId;
        return $this;
    }

    public function setSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function setExtendsInfoData($extendsInfoData)
    {
        $this->extends_info_data = (string) $extendsInfoData;
        return $this;
    }

    public function setGameCurrency($gameCurrency)
    {
        $this->game_currency = (string)$gameCurrency;
        return $this;
    }
    
    public function setGameAccessVersion($gameAccessVersion)
    {
        $this->game_access_version = (string)$gameAccessVersion;
        return $this;
    }

    public function done($x7PublicKey, $signField = [])
    {
        if (empty($signField) || !is_array($signField)) {
            //默认需要签名的字段
            $signField = [
                "extends_info_data",
                "game_area",
                "game_level",
                "game_guid",
                "game_orderid",
                'game_price', 
                'game_role_id', 
                'game_role_name', 
                'notify_id',
                'subject',
                'game_access_version'
            ];
        }

        if (!ParamTool::isValidPublicKey($x7PublicKey)) {
            throw new RuntimeException("RSA公钥有误");
        }

        $queryArr = $this->toArray();

        if (version_compare($queryArr['game_access_version'], '7.98') >= 0) {
            $signField[] = 'game_currency';
        }
        $signArr = [];
        foreach ($queryArr as $key => $value) {
            if (in_array($key, $signField)) {
                $signArr[$key] = $value;
            }
        }
        ksort($signArr);
        $signStr = ParamTool::buildQueryString($signArr, false);
        $queryArr['game_sign'] = md5($signStr . $x7PublicKey);
        return $queryArr;
    }
}
