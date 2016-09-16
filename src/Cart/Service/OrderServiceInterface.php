<?php
namespace Cart\Service;

/**
 * The implementation is responsible for retrieving order(s) 
 * from a datasource (JSON in our case)
 *
 * @author wsm_team
 */
interface OrderServiceInterface
{

    /**
     * Load order by ID.
     * 
     * @param string $orderId ID of an order to search for.
     *
     * @return \Cart\Entity\Order
     */
    public function getOrderById($orderId);

    /**
     * Load orders by custom attribute value.
     * 
     * @param string $attribute
     * @param string $value
     *
     * @return \Cart\Entity\Order[]
     */
    public function getOrdersByAttribute($attribute, $value);

    /**
     * Load orders for a period of time
     * 
     * @param string $from
     * @param string $to
     *
     * @return \Cart\Entity\Order[]
     */
    public function getOrdersForPeriod($from, $to);

}
