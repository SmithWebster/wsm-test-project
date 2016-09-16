<?php

require_once('init.php');

$os = new Cart\Service\OrderService($jsonFilePath);
$os->parse('orders');

$key = 'status';
$value = \Cart\Entity\Order::STATUS_PENDING;
$orders = $os->getOrdersByAttribute($key, $value);

echo "Orders with {$key} = {$value}\n";
if (!empty($orders)) {
    foreach ($orders as &$order) {
        echo "\n\n";
        $os->showOrderDetails($order);
    }
}

$id = 100000081;
$specOrder = $os->getOrderById($id);

echo "\n\n";
echo "Special order with ID {$id}\n";
$os->showOrderDetails($specOrder);

