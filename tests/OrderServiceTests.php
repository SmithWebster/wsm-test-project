<?php

require_once(__DIR__ . '/../src/SplClassLoader.php');
$loader = new SplClassLoader('Cart', __DIR__ . '/../src');
$loader->register();

class OrderServiceTest extends PHPUnit\Framework\TestCase {

    const JSON_FILE_PATH = __DIR__ . '/data/200610120800.json';

    public function jsonPathProvider() {
        return [[
            self::JSON_FILE_PATH,
        ]];
    }

    public function serviceProvider() {
        $data = $this->jsonPathProvider();
        $jsonPath = current(current($data));
        $service = new \Cart\Service\OrderService($jsonPath);
        //$service->parse('orders');

        return [[
            $service,
        ]];
    }

    /**
     * @dataProvider jsonPathProvider
     */
    public function testInit($jsonPath) {
        $data = $this->serviceProvider();
        $service = current(current($data));
        $this->assertNotNull($service);
    }

    /**
     * @dataProvider serviceProvider
     */
    public function testParse($service) {
        $service->parse('orders');
        $orders = $service->getOrders();
        $this->assertNotEmpty($orders);
        $this->assertEquals(count($orders), 4);
    }

    /**
     * @dataProvider serviceProvider
     */
    public function testInvalidParse($service) {
        try {
            $service->parse('undefined-orders');
        } catch (\Exception $e) {
            //do nothing
        }
        $orders = $service->getOrders();
        $this->assertEmpty($orders);
    }

    /**
     * @dataProvider serviceProvider
     */
    public function testGetOrderById($service) {
        $service->parse('orders');
        $id = 100000049;
        $order = $service->getOrderById($id);
        $this->assertNotNull($order);
        $this->assertEquals($order->id, $id);
    }

    /**
     * @dataProvider serviceProvider
     */
    public function testGetOrderByInvalidId($service) {
        $service->parse('orders');
        $id = 9999;
        $order = $service->getOrderById($id);
        $this->assertNull($order);
    }

    /**
     * @dataProvider serviceProvider
     */
    public function testGetOrdersByAttribute($service) {
        $service->parse('orders');

        $key = 'id';
        $value = 100000049;
        $res = $service->getOrdersByAttribute($key, $value);

        $this->assertEquals(count($res), 1);
        $res = current($res);

        $this->assertEquals($res->$key, $value);
    }
}

