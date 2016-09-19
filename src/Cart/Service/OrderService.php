<?php
namespace Cart\Service;

class OrderService implements OrderServiceInterface {

    /**
     * @var JSON file path for data parsing
     */
    protected $_jsonFilePath = null;

    /**
     * @var orders list
     */
    protected $_orders = [];

    #TODO the best way for PHP7, it required to reimplement the interface with
    # public function getOrderById(int $orderId): \Cart\Entity\Order {
    /**
     * Load order by ID.
     * 
     * @param string $orderId ID of an order to search for.
     *
     * @return \Cart\Entity\Order
     */
    public function getOrderById($orderId) {
        $tmp = array_filter($this->_orders, function($order) use($orderId) {
            return $order->id == $orderId;
        });
        if (empty($tmp)) {
            return null;
        }
        return current($tmp);
    }

    /**
     * Load orders by custom attribute value.
     * 
     * @param string $attribute
     * @param string $value
     *
     * @return \Cart\Entity\Order[]
     */
    public function getOrdersByAttribute($attribute, $value) {
        $orders = array_filter($this->_orders, function($order) use(&$attribute, &$value) {
            if (isset($order->$attribute) && $order->$attribute == $value) {
                return $order;
            }
        });

        return $orders;
    }

    /**
     * Load orders for a period of time
     * 
     * @param string $from
     * @param string $to
     *
     * @return \Cart\Entity\Order[]
     */
    public function getOrdersForPeriod($from, $to) {
        //TODO
    }

    public function __construct(string $jsonFilePath) {
        $this->_jsonFilePath = $jsonFilePath;
    }

    public function parse(string $key = null) {
        $jsonRaw = file_get_contents($this->_jsonFilePath);

        $json = json_decode($jsonRaw, true);
        if (is_null($json)) {
            throw new \Exception('JSON parsing error. Code ' . json_last_error());
        }

        $fails = !$this->_validateJson($json);
        if ($fails) {
            throw new \Exception('Invalid JSON format');
        }

        if (!is_null($key)) {
            $json = &$json[$key];

            if (is_null($json)) {
                throw new \Exception($key . ' key is not exists!');
            }
        }

        $this->_orders = $this->_buildOrdersList($json);
    }

    public function getOrders(): array {
        return $this->_orders;
    }

    /**
     * @param array $json
     *
     * @return bool
     */
    protected function _validateJson(array $json): bool {
        #TODO make validation of json format
        return true;
    }

    /**
     * @param array $json
     *
     * @return array
     */
    protected function _buildOrdersList(array $json): array {
        if (empty($json)) {
            return [];
        }

        $list = [];
        foreach ($json as &$item) {
            $order = $this->_buildOrder($item);
            $list[] = $order;
        }

        return $list;
    }

    /**
     * @param array $data Array of data for filling the Order object
     *
     * @return \Cart\Entity\Order
     */
    protected function _buildOrder(array $data): \Cart\Entity\Order {
        $order = new \Cart\Entity\Order();
        $order->setData($data);
        return $order;
    }

    public function showOrderDetails(\Cart\Entity\Order $order) {
        echo "ID: " . $order->id . "\n";
        echo "Status: " . $order->getStatusName() . "\n";
        echo "Number of ordered items: " . count($order->items) . "\n";
        echo "Total: " . $order->getTotal() . "\n";
        echo "Shipping method: " . $order->shipping_method . "\n";
        echo "Date: " . $order->created_at . "\n";
    }
}

