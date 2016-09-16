<?php

require_once('init.php');

$os = new Cart\Service\OrderService($jsonFilePath);
$os->parse('orders');
$orders = $os->getOrders();

var_dump($orders);

