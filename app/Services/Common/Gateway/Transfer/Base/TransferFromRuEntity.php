<?php
/**
 * Created by PhpStorm.
 * User: F_Abdurashidov
 * Date: 17.04.2020
 * Time: 10:28
 */

namespace  App\Services\Common\Gateway\Transfer\Base;

use App\Services\Common\Gateway\Transfer\Base\IRequest;


class TransferFromRuEntity implements IRequest
{

    private $action;
    private $account;
    private $amount;
    private $currency;
    private $settlement_curr;
    private $curr_rate;
    private $pay_id;
    private $pay_date;
    private $service_type;
    private $card_type;


    public function getAllParamsToArray()
    {
        $exceptMethod = __FUNCTION__;
        // динамический получая название методов генериреум название параметров в виде массива
        $getters = array_filter(get_class_methods($this), function ($method) use ($exceptMethod) {
            return 'get' === substr($method, 0, 3) && $method !== $exceptMethod;
        });

        foreach ($getters as $item) {

            if ($this->{$item}() !== null || !empty($this->{$item}())) {
                $key = substr($item, 3, strlen($item) - 3);
                $this->data[strtoupper($key)] = $this->{$item}();
            }
        }

        return $this->data;
    }


    /**
     * Get the value of opt
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * Set the value of opt
     *
     * @return  self
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * Get the value of opt
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set the value of opt
     *
     * @return  self
     */
    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * Get the value of opt
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set the value of opt
     *
     * @return  self
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get the value of opt
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set the value of opt
     *
     * @return  self
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * Get the value of opt
     */
    public function getSettlement_curr()
    {
        return $this->settlement_curr;
    }

    /**
     * Set the value of opt
     *
     * @return  self
     */
    public function setSettlement_curr($settlement_curr)
    {
        $this->settlement_curr = $settlement_curr;
    }

    /**
     * Get the value of opt
     */
    public function getCurr_rate()
    {
        return $this->curr_rate;
    }

    /**
     * Set the value of opt
     *
     * @return  self
     */
    public function setCurr_rate($curr_rate)
    {
        $this->curr_rate = $curr_rate;
    }

    /**
     * Get the value of opt
     */
    public function getPay_id()
    {
        return $this->pay_id;
    }

    /**
     * Set the value of opt
     *
     * @return  self
     */
    public function setPay_id($pay_id)
    {
        $this->pay_id = $pay_id;
    }

    /**
     * Get the value of opt
     */
    public function getPay_date()
    {
        return $this->pay_date;
    }

    /**
     * Set the value of opt
     *
     * @return  self
     */
    public function setPay_date($pay_date)
    {
        $this->pay_date = $pay_date;
    }

    /**
     * Get the value of service_type
     */ 
    public function getService_type()
    {
        return $this->service_type;
    }

    /**
     * Set the value of service_type
     *
     * @return  self
     */ 
    public function setService_type($service_type)
    {
        $this->service_type = $service_type;
    }

    /**
     * Get the value of card_type
     */ 
    public function getCard_type()
    {
        return $this->card_type;
    }

    /**
     * Set the value of card_type
     *
     * @return  self
     */ 
    public function setCard_type($card_type)
    {
        $this->card_type = $card_type;
    }
}