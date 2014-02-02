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
 * Warranty Promise
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/WarrantyPromise
 */
class WarrantyPromise extends StructuredValue
{
    /**
     * Duration of Warranty
     *
     * @var QuantitativeValue The duration of the warranty promise. Common unitCode values are ANN for year, MON for months, or DAY for days.
     */
    protected $durationOfWarranty;
}
