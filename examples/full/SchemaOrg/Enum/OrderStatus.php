<?php


namespace SchemaOrg\Enum;

use MyCLabs\Enum\Enum;

/**
 * Enumerated status values for Order.
 * 
 * @see http://schema.org/OrderStatus Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OrderStatus extends Enum
{
    /**
     * @type string ORDER_CANCELLED OrderStatus representing cancellation of an order.
    */
    const ORDER_CANCELLED = 'http://schema.org/OrderCancelled';
    /**
     * @type string ORDER_DELIVERED OrderStatus representing successful delivery of an order.
    */
    const ORDER_DELIVERED = 'http://schema.org/OrderDelivered';
    /**
     * @type string ORDER_IN_TRANSIT OrderStatus representing that an order is in transit.
    */
    const ORDER_IN_TRANSIT = 'http://schema.org/OrderInTransit';
    /**
     * @type string ORDER_PAYMENT_DUE OrderStatus representing that payment is due on an order.
    */
    const ORDER_PAYMENT_DUE = 'http://schema.org/OrderPaymentDue';
    /**
     * @type string ORDER_PICKUP_AVAILABLE OrderStatus representing availability of an order for pickup.
    */
    const ORDER_PICKUP_AVAILABLE = 'http://schema.org/OrderPickupAvailable';
    /**
     * @type string ORDER_PROBLEM OrderStatus representing that there is a problem with the order.
    */
    const ORDER_PROBLEM = 'http://schema.org/OrderProblem';
    /**
     * @type string ORDER_PROCESSING OrderStatus representing that an order is being processed.
    */
    const ORDER_PROCESSING = 'http://schema.org/OrderProcessing';
    /**
     * @type string ORDER_RETURNED OrderStatus representing that an order has been returned.
    */
    const ORDER_RETURNED = 'http://schema.org/OrderReturned';
}
