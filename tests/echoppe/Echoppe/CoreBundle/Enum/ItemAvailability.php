<?php

/*
 * This file is part of the Échoppe package.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Echoppe\CoreBundle\Enum;

/**
 * A list of possible product availability options.
 *
 * @see http://schema.org/ItemAvailability Documentation on Schema.org
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class ItemAvailability extends Enum
{
    /**
     * @type string Discontinued
     */
    const DISCONTINUED = 'http://schema.org/Discontinued';
    /**
     * @type string InStock
     */
    const IN_STOCK = 'http://schema.org/InStock';
    /**
     * @type string InStoreOnly
     */
    const IN_STORE_ONLY = 'http://schema.org/InStoreOnly';
    /**
     * @type string LimitedAvailability
     */
    const LIMITED_AVAILABILITY = 'http://schema.org/LimitedAvailability';
    /**
     * @type string OnlineOnly
     */
    const ONLINE_ONLY = 'http://schema.org/OnlineOnly';
    /**
     * @type string OutOfStock
     */
    const OUT_OF_STOCK = 'http://schema.org/OutOfStock';
    /**
     * @type string PreOrder
     */
    const PRE_ORDER = 'http://schema.org/PreOrder';
    /**
     * @type string SoldOut
     */
    const SOLD_OUT = 'http://schema.org/SoldOut';
}
