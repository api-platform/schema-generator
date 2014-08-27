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
 *  A point value or interval for product characteristics and other purposes.
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/QuantitativeValue Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class QuantitativeValue extends StructuredValue
{
    /**
     * @type string $unitCode The unit of measurement given using the UN/CEFACT Common Code (3 characters).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $unitCode;
    /**
     * @type float $value The value of the product characteristic.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $value;
}
