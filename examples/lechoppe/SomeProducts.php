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

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Some Products
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/SomeProducts
 * 
 * @ORM\Entity
 */
class SomeProducts extends Product
{
    /**
     * Inventory Level
     * 
     * @var QuantitativeValue $inventoryLevel The current approximate inventory level for the item or items.
     * 
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $inventoryLevel;
}
