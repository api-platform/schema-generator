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
 * Type And Quantity Node
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/TypeAndQuantityNode
 */
class TypeAndQuantityNode extends StructuredValue
{
    /**
     * Amount of This Good
     *
     * @var float The quantity of the goods included in the offer.
     */
    protected $amountOfThisGood;
    /**
     * Type of Good
     *
     * @var Product The product that this structured value is referring to.
     */
    protected $typeOfGood;
    /**
     * Unit Code
     *
     * @var string The unit of measurement given using the UN/CEFACT Common Code (3 characters).
     */
    protected $unitCode;
}
