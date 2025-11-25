<?php

namespace X7\Module\Common\Response;

use RuntimeException;
use X7\Handler\ParamHandlerInterface;
use X7\Model\OrderSearchOrder;
use X7\Module\Common\Constant\ApiMethod;
use X7\Response\BizRespValidatorInterface;
use X7\Response\CommonResponse;

class OrderSearchResponse extends CommonResponse implements BizRespValidatorInterface
{
    /**
     * 订单列表
     * @var OrderSearchOrder[]
     */
    public $orderList = [];

    protected $apiMethod = ApiMethod::ORDER_QUERY;

     /**
     * 校验
     *
     * @param ParamHandlerInterface $bizResp
     * @return self
     * @throws RuntimeException
     */
    public function validateBizResp(ParamHandlerInterface $bizResp)
    {
        $orderList = $bizResp->getInputValue("orderList");
        foreach ($orderList as $order) {
            $this->orderList[] = OrderSearchOrder::make($order);
        }
        return $this;
    }
}
