<?php
namespace Cart\Entity\Order;

/**
 * Discount model
 *
 * @author wsm_team
 */
class Discount
{

    /**
     * Coupon code
     * 
     * @var string
     */
    public $code;

    /**
     * Discount amount
     *
     * @var float
     */
    public $amount;

    /**
     * Rule Name
     *
     * @var string
     */
    public $rule;
   
    public function setData(array $data) {
        foreach ($data as $key => &$value) {
            switch ($key) {
                case 'coupon_code':
                    $this->setCode($value);
                    break;

                case 'discount_amount':
                    $this->setAmount((float) $value);
                    break;

                case 'coupon_rule_name':
                    $this->setRule($value);
                    break;
            }
        }
    }

    public function setCode($code) {
        $this->code = $code;
    }

    public function setAmount(float $amount) {
        $this->amount = $amount;
    }

    public function setRule($rule) {
        $this->rule = $rule;
    }
}

