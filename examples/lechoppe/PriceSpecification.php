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
 * Price Specification
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/PriceSpecification
 */
class PriceSpecification extends StructuredValue
{
    /**
     * Eligible Quantity
     *
     * @var QuantitativeValue The interval and unit of measurement of ordering quantities for which the offer or price specification is valid. This allows e.g. specifying that a certain freight charge is valid only for a certain quantity.
     */
    protected $eligibleQuantity;
    /**
     * Eligible Transaction Volume
     *
     * @var PriceSpecification The transaction volume, in a monetary unit, for which the offer or price specification is valid, e.g. for indicating a minimal purchasing volume, to express free shipping above a certain order volume, or to limit the acceptance of credit cards to purchases to a certain minimal amount.
     */
    protected $eligibleTransactionVolume;
    /**
     * Max Price
     *
     * @var float The highest price if the price is a range.
     */
    protected $maxPrice;
    /**
     * Min Price
     *
     * @var float The lowest price if the price is a range.
     */
    protected $minPrice;
    /**
     * Price (Text)
     *
     * @var string The offer price of a product, or of a price component when attached to PriceSpecification and its subtypes.
     */
    protected $priceText;
    /**
     * Price (Number)
     *
     * @var float The offer price of a product, or of a price component when attached to PriceSpecification and its subtypes.
     */
    protected $priceNumber;
    /**
     * Price Currency
     *
     * @var string The currency (in 3-letter ISO 4217 format) of the offer price or a price component, when attached to PriceSpecification and its subtypes.
     */
    protected $priceCurrency;
    /**
     * Valid From
     *
     * @var \DateTime The date when the item becomes valid.
     */
    protected $validFrom;
    /**
     * Valid Through
     *
     * @var \DateTime The end of the validity of offer, price specification, or opening hours data.
     */
    protected $validThrough;
    /**
     * Value Added Tax Included
     *
     * @var boolean Specifies whether the applicable value-added tax (VAT) is included in the price specification or not.
     */
    protected $valueAddedTaxIncluded;
}
