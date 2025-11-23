<?php

namespace X7\Module\Common\Model;

/**
 * 订单查询订单信息
 */
class OrderSearchOrder
{
    /**
     * 小7订单ID
     * 
     * @var string
     */
    public $goid;

    /**
     * 游戏订单号，对应支付下单接口的game_orderid
     * 
     * @var string
     */
    public $gameOrderId;

    /**
     * 小7小号ID
     * 
     * @var string
     */
    public $guid = '';

    /**
     * 订单原价
     * 
     * @var string
     */
    public $gamePrice = '';

    /**
     * 购买的道具商品
     * 
     * @var string
     */
    public $subject = '';

    /**
     * 订单来源类型
     * 
     * @var string
     */
    public $orderFrom = '';

    /**
     * 订单创建时间
     * 
     * @var float
     */
    public $createTime = '';
    
    /**
     * 订单支付时间
     * 
     * @var string
     */
    public $payTime = '';

    /**
     * 玩家实际支付金额
     * 
     * @var string
     */
    public $payPrice = '';

    /**
     * 代金券抵扣金额
     * 
     * @var string
     */
    public $couponDeductPrice = '';

    /**
     * 充值卡代金券抵扣金额
     * 
     * @var string
     */
    public $rechargeCardDeductPrice = '';

    /**
     * 充值卡代金券抵扣金额中的赠送金额部分
     * 
     * @var string
     */
    public $rechargeCardRewardDeductPrice = '';

    /**
     * 关联的竞技场ID
     * 
     * @var string
     */
    public $arenaId = '';
}