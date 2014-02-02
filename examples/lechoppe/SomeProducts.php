<?php

/*
 * This file is part of the L'Échoppe package.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Echoppe\CoreBundle\Entity;

/**
 * Some Products
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/SomeProducts
 */
class SomeProducts extends Product
{
    /**
     * Inventory Level
     *
     * @var QuantitativeValue The current approximate inventory level for the item or items.
     */
    protected $inventoryLevel;
}
