<?php
namespace Cart\Entity;

/**
 * Order model. 
 * 
 * You should calculate order total value taking into account discount rule that may apply
 *
 * @author wsm_team
 */
class Order
{

    const STATUS_PENDING = 1;
    const STATUS_COMPLETE = 2;
    const STATUS_CANCELED = 3;

    /**
     * Order Id
     * 
     * @var int
     */
    public $id;

    /**
     * Order Status
     *
     * @var string
     */
    public $status;

    /**
     * Order Discount
     *
     * @var Discount|null
     */
    public $discount;

    /**
     * Purchased products
     *
     * @var Item[]
     */
    public $items = array();

    /**
     * Order Total
     *
     * @var float
     */
    public $total;

    /**
     * Shipping Method
     *
     * @var string
     */
    public $shipping_method;

    /**
     * Order Created Datetime
     *
     * @var string
     */
    public $created_at;
   

    public function setData(array $data) {
        foreach ($data as $key => &$value) {
            switch ($key) {
                case 'id':
                    $this->setId((int) $value);
                    break;

                case 'status':
                    $this->setStatus($value);
                    break;

                case 'discount':
                    $this->setDiscount($value);
                    break;

                case 'items':
                    $this->setItems($value);
                    break;

                case 'shipping_method':
                    $this->setShippingMethod($value);
                    break;

                case 'created_at':
                    $this->setCreatedAt($value);
                    break;
            }
        }
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    /**
     * @param int|string $status
     */
    public function setStatus($status) {
        $val = null;
        if (is_string($status)) {
            switch ($status) {
                case 'pending':
                    $val = self::STATUS_PENDING;
                    break;

                case 'canceled':
                    $val = self::STATUS_CANCELED;
                    break;

                case 'complete':
                    $val = self::STATUS_COMPLETE;
                    break;
            }
        } else if (is_numeric($status)) {
            // if not in range of predefined values
            !in_array($status, [
                self::STATUS_PENDING,
                self::STATUS_COMPLETE,
                self::STATUS_CANCELED,
            ]) ?: $val = $status;
        }

        if (!is_null($val)) {
            $this->status = $val;
        } else {
            // value has not detected, so we need to..
            #TODO throw exception or email or another. Any way to notify user
        }
    }

    public function setDiscount(array $data) {
        $discount = new \Cart\Entity\Order\Discount();
        $discount->setData($data);
        $this->discount = $discount;
    }

    public function setItems(array $items) {
        $itemProto = new \Cart\Entity\Order\Item();

        $this->items = [];
        foreach ($items as $key => &$itemData) {
            $item = clone $itemProto;
            $item->setData($itemData);
            $this->items[$key] = $item;
        }
    }

    public function setShippingMethod(string $method) {
        $this->shipping_method = $method;
    }

    public function setCreatedAt(string $timestamp) {
        $this->created_at = $timestamp;
    }

    public function getSortItemsBy(string $field, array $items = null) {
        if (is_null($items)) {
            $items = $this->items;
        }

        if (empty($items)) {
            return $items;
        }

        uasort($items, function($a, $b) use($field) {
            return strnatcmp($a->$field, $b->$field);
        });

        return $items;
    }

    public function getStatusName() {
        $name = null;

        switch ($this->status) {
            case self::STATUS_PENDING:
                $name = 'pending';
                break;

            case self::STATUS_COMPLETE:
                $name = 'complete';
                break;

            case self::STATUS_CANCELED:
                $name = 'canceled';
                break;

            default:
                $name = 'unknown';
                break;
        }

        return $name;
    }

    public function getTotal(): float {
        //TODO discount calculation rules required
        if (empty($this->total)) {
            $sum = 0;
            foreach ($this->items as &$item) {
                $sum += $item->price;
            }

            if (!empty($this->discount) && !empty($this->discount->amount)) {
                $sum += $this->discount->amount;
            }

            $this->total = $sum;
        }

        return (float) $this->total;
    }
}

