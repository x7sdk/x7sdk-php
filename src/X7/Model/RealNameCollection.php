<?php

namespace X7\Model;

/**
 * 实名认证上报集合项
 */
class RealNameCollection extends Model
{
    /**
     * 条目编码
     * 
     * @var int
     */
    public $no;
    
    /**
     * 游戏内部会话标识
     * 
     * @var string
     */
    public $si;
    
    /**
     * 游戏用户行为类型【0：下线；1：上线】
     * 
     * @var int
     */
    public $bt;
    
    /**
     * 行为发生时间戳，单位秒
     * 
     * @var int
     */
    public $ot;
    
    /**
     * 用户行为数据上报类型【0：已认证通过用户；2：游客用户】
     * 
     * @var int
     */
    public $ct;
    
    /**
     * 游客模式设备标识，由游戏运营单位生成，游客用户下必填
     * 
     * @var string
     */
    public $di;
    
    /**
     * 已通过实名认证用户的唯一标识，已认证通过用户必填
     * 
     * @var string
     */
    public $pi;
    
    /**
     * 可选参数
     * 注意：di和pi根据ct字段值决定是否必填
     * ct=0（已认证用户）：pi必填，di可选
     * ct=2（游客用户）：di必填，pi可选
     *
     * @var array
     */
    protected static $optionalFields = [];
    
    /**
     * 重写make方法，添加自定义验证逻辑
     *
     * @param array $paramArr
     * @return static
     * @throws \RuntimeException
     */
    public static function make($paramArr)
    {
        if (!is_array($paramArr)) {
            throw new \RuntimeException("构造Model参数必须为数组");
        }
        
        // 根据ct字段值动态设置可选字段
        $ct = isset($paramArr['ct']) ? (int)$paramArr['ct'] : null;
        
        if ($ct === 0) {
            // 已认证通过用户：pi必填，di可选
            static::$optionalFields = ['di'];
        } elseif ($ct === 2) {
            // 游客用户：di必填，pi可选
            static::$optionalFields = ['pi'];
        } else {
            // 其他情况：两个字段都必填
            static::$optionalFields = [];
        }
        
        return parent::make($paramArr);
    }
}