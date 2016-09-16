<?php
namespace Cart\Service\Order;

/**
 * The implementation is responsible for retrieving items 
 * from a datasource (JSON in our case)
 *
 * @author wsm_team
 */
interface ItemServiceInterface
{

    /**
     * Load all items by order ID
     * 
     * @param string $orderId
     *
     * @return \Cart\Entity\Order\Item[]
     */
    public function getAllOrderItems($orderId);
    
}
