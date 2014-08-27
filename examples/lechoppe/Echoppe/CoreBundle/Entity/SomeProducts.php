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
 * A placeholder for multiple similar products of the same kind.
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/SomeProducts Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SomeProducts extends Product
{
    /**
     * @type QuantitativeValue $inventoryLevel The current approximate inventory level for the item or items.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $inventoryLevel;
}
