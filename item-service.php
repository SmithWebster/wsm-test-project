<?php

require_once('init.php');

$is = new Cart\Service\Order\ItemService($jsonFilePath);

$orderBy = 'name';
//$orderBy = 'qty';
//$orderBy = 'price';
//$orderBy = 'weight';
$items = $is->getAllItemsOrderBy($orderBy);

echo "Sortable by {$orderBy}\n";
echo "--------------------\n";
foreach ($items as $i) {
    echo $i->$orderBy . "\n";
}

