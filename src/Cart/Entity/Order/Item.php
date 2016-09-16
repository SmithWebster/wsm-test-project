<?php
namespace Cart\Entity\Order;

/**
 * Item model
 *
 * @author wsm_team
 */
class Item
{

    /**
     * Product SKU
     * 
     * @var string
     */
    public $sku;

    /**
     * Product Name
     *
     * @var string
     */
    public $name;

    /**
     * Quantity
     *
     * @var int
     */
    public $qty;

    /**
     * Price
     *
     * @var float
     */
    public $price;

    /**
     * Weight
     *
     * @var float
     */
    public $weight;
   

    public function setData(array $data) {
        foreach ($data as $key => &$value) {
            switch ($key) {
                case 'sku':
                    $this->setSku($value);
                    break;

                case 'name':
                    $this->setName($value);
                    break;

                case 'qty':
                    $this->setQty((int) $value);
                    break;

                case 'price':
                    $this->setPrice($value);
                    break;

                case 'weight':
                    $this->setWeight($value);
                    break;
            }
        }
    }

    public function setSku(string $val) {
        $this->sku = $val;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function setQty(int $qty) {
        $this->qty = $qty;
    }

    public function setPrice(float $price) {
        $this->price = $price;
    }

    public function setWeight(float $weight) {
        $this->weight = $weight;
    }
}

