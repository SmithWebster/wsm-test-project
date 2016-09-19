<?php

require_once(__DIR__ . '/../src/SplClassLoader.php');
$loader = new SplClassLoader('Cart', __DIR__ . '/../src');
$loader->register();

class ItemServiceTest extends PHPUnit\Framework\TestCase {

    const JSON_FILE_PATH = __DIR__ . '/data/200610120800.json';
    const JSON_SHA1 = 'e6fe0d17de5bfdf4a937147120ee576b6445dbe9';

    public function jsonPathProvider() {
        return [[
            self::JSON_FILE_PATH,
        ]];
    }

    public function jsonProvider($jsonPath) {
        $json = json_decode(file_get_contents(self::JSON_FILE_PATH), true);
        $sha1 = sha1(file_get_contents(self::JSON_FILE_PATH));

        $this->assertEquals($sha1, self::JSON_SHA1, "Invalid json file");

        return [[
            $json
        ]];
    }

    public function serviceProvider() {
        $data = $this->jsonPathProvider();
        $jsonPath = current(current($data));
        $service = new \Cart\Service\Order\ItemService($jsonPath);
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
    public function testGetAllOrderItemsWithIds($service) {
        $ids = [
            100000049,
            100000051,
            100000067,
            100000081,
        ];

        foreach ($ids as $id) {
            $res = $service->getAllOrderItems($id);
            $this->assertNotNull($res);
            $this->assertInstanceOf(\Cart\Entity\Order::class, $res);
        }
    }

    /**
     * @dataProvider serviceProvider
     */
    public function testGetAllOrderItemsWithInvalidIds($service) {
        $ids = [
            9999,
            10001,
            10004,
            10007,
        ];

        foreach ($ids as $id) {
            $res = $service->getAllOrderItems($id);
            $this->assertNull($res);
        }
    }

    /**
     * @dataProvider serviceProvider
     */
    public function testGetAllItemsOrderBy($service) {
        $orderFields = [
            'name' => '5dc8dfeb1dc4d8fa9818e2321233e705ccfaee5f',
            'qty' => '765ab558444a356a843d9db87a0852a834793d6e',
            'price' => '6c8d0529b120cae8386a17b5c9692abf1ff84078',
            'weight' => '765ab558444a356a843d9db87a0852a834793d6e',
        ];

        foreach ($orderFields as $field => $sha1) {
            $res = $service->getAllItemsOrderBy($field);
            $first = current($res);
            $this->assertEquals(sha1($first->name . $first->price), $sha1);
        }
    }
}

