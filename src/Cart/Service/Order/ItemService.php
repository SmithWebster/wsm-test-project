<?php
namespace Cart\Service\Order;

class ItemService implements ItemServiceInterface {

    protected $_orders = [];

    /**
     * Load all items by order ID
     * 
     * @param string $orderId
     *
     * @return \Cart\Entity\Order\Item[]
     */
    public function getAllOrderItems($orderId) {
        $res = array_filter($this->_orders, function($order) use($orderId) {
            return $order->id == $orderId;
        });
        return !empty($res) ? current($res) : null;
    }

    public function __construct(string $jsonFilePath) {
        $os = new \Cart\Service\OrderService($jsonFilePath);
        $os->parse('orders');
        $this->_orders = $os->getOrders();
    }

    /**
     * @param string $orderBy
     *
     * @return array
     */
    public function getAllItemsOrderBy(string $orderBy): array {
        $allItems = [];

        foreach ($this->_orders as &$order) {
            $allItems = array_merge($allItems, $order->items);
        }

        // sort together
        $allItems = (new \Cart\Entity\Order())->getSortItemsBy($orderBy, $allItems);
        return $allItems;
    }
}

