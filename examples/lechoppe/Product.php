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
 * Product
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/Product
 */
class Product extends Thing
{
    /**
     * Brand
     *
     * @var Brand The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     */
    protected $brand;
    /**
     * Color
     *
     * @var string The color of the product.
     */
    protected $color;
    /**
     * Depth
     *
     * @var QuantitativeValue The depth of the product.
     */
    protected $depth;
    /**
     * Gtin13
     *
     * @var string The GTIN-13 code of the product, or the product to which the offer refers. This is equivalent to 13-digit ISBN codes and EAN UCC-13. Former 12-digit UPC codes can be converted into a GTIN-13 code by simply adding a preceeding zero.
     */
    protected $gtin13;
    /**
     * Gtin14
     *
     * @var string The GTIN-14 code of the product, or the product to which the offer refers.
     */
    protected $gtin14;
    /**
     * Gtin8
     *
     * @var string The GTIN-8 code of the product, or the product to which the offer refers. This code is also known as EAN/UCC-8 or 8-digit EAN.
     */
    protected $gtin8;
    /**
     * Height
     *
     * @var QuantitativeValue The height of the item.
     */
    protected $height;
    /**
     * Item Condition
     *
     * @var OfferItemCondition A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.
     */
    protected $itemCondition;
    /**
     * Mpn
     *
     * @var string The Manufacturer Part Number (MPN) of the product, or the product to which the offer refers.
     */
    protected $mpn;
    /**
     * Offers
     *
     * @var Offer An offer to sell this item—for example, an offer to sell a product, the DVD of a movie, or tickets to an event.
     */
    protected $offers;
    /**
     * Release Date
     *
     * @var \DateTime The release date of a product or product model. This can be used to distinguish the exact variant of a product.
     */
    protected $releaseDate;
    /**
     * Sku
     *
     * @var string The Stock Keeping Unit (SKU), i.e. a merchant-specific identifier for a product or service, or the product to which the offer refers.
     */
    protected $sku;
    /**
     * Weight
     *
     * @var QuantitativeValue The weight of the product.
     */
    protected $weight;
    /**
     * Width
     *
     * @var QuantitativeValue The width of the item.
     */
    protected $width;
}
