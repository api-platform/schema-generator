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
 * Quantitative Value
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/QuantitativeValue
 */
class QuantitativeValue extends StructuredValue
{
    /**
     * Max Value
     *
     * @var float The upper of the product characteristic.
     */
    protected $maxValue;
    /**
     * Min Value
     *
     * @var float The lower value of the product characteristic.
     */
    protected $minValue;
    /**
     * Unit Code
     *
     * @var string The unit of measurement given using the UN/CEFACT Common Code (3 characters).
     */
    protected $unitCode;
    /**
     * Value
     *
     * @var float The value of the product characteristic.
     */
    protected $value;
}
