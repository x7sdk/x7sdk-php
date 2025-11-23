<?php

namespace X7\Module\Common\Response;

use RuntimeException;
use X7\Handler\ParamHandlerInterface;
use X7\Module\Common\Constant\ApiMethod;
use X7\Module\Common\Model\OrderSearchOrder;
use X7\Response\CommonResponse;

class GameOrderSearchResponse extends CommonResponse
{
    /**
     * 订单列表
     * @var OrderSearchOrder[]
     */
    public $orderList = [];

    protected $apiMethod = ApiMethod::ORDER_QUERY;

    /**
     * 设置订单列表
     * @param OrderSearchOrder[] $orderList
     * @return self
     */
    public function setOrderList($orderList)
    {
        foreach ($orderList as $order) {
            if (!($order instanceof OrderSearchOrder)) {
                throw new RuntimeException("orderList数组内元素类型必须为 X7\Model\GameOrder");
            }
        }
        $this->orderList = $orderList;
        return $this;
    }


     /**
     * 校验
     *
     * @param ParamHandlerInterface $bizResp
     * @return self
     * @throws RuntimeException
     */
    public function validateBizResp(ParamHandlerInterface $bizResp)
    {
        return $this->setOrderList($bizResp->getInputValue("orderList"));
    }
}
