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
 * Product
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/Product
 * 
 * @ORM\MappedSuperclass
 */
class Product extends Thing
{
    /**
     * Brand
     * 
     * @var Brand $brand The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     * 
     * @ORM\ManyToOne(targetEntity="Brand")
     */
    private $brand;
    /**
     * Color
     * 
     * @var string $color The color of the product.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $color;
    /**
     * Depth
     * 
     * @var QuantitativeValue $depth The depth of the product.
     * 
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $depth;
    /**
     * Gtin13
     * 
     * @var string $gtin13 The GTIN-13 code of the product, or the product to which the offer refers. This is equivalent to 13-digit ISBN codes and EAN UCC-13. Former 12-digit UPC codes can be converted into a GTIN-13 code by simply adding a preceeding zero.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gtin13;
    /**
     * Gtin14
     * 
     * @var string $gtin14 The GTIN-14 code of the product, or the product to which the offer refers.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gtin14;
    /**
     * Gtin8
     * 
     * @var string $gtin8 The GTIN-8 code of the product, or the product to which the offer refers. This code is also known as EAN/UCC-8 or 8-digit EAN.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gtin8;
    /**
     * Height
     * 
     * @var QuantitativeValue $height The height of the item.
     * 
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $height;
    /**
     * Item Condition
     * 
     * @var OfferItemCondition $itemCondition A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.
     * 
     * @ORM\ManyToOne(targetEntity="OfferItemCondition")
     */
    private $itemCondition;
    /**
     * Mpn
     * 
     * @var string $mpn The Manufacturer Part Number (MPN) of the product, or the product to which the offer refers.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $mpn;
    /**
     * Offers
     * 
     * @var Offer $offers An offer to transfer some rights to an item or to provide a service—for example, an offer to sell tickets to an event, to rent the DVD of a movie, to stream a TV show over the internet, to repair a motorcycle, or to loan a book.
     * 
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $offers;
    /**
     * Release Date
     * 
     * @var \DateTime $releaseDate The release date of a product or product model. This can be used to distinguish the exact variant of a product.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $releaseDate;
    /**
     * Sku
     * 
     * @var string $sku The Stock Keeping Unit (SKU), i.e. a merchant-specific identifier for a product or service, or the product to which the offer refers.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $sku;
    /**
     * Weight
     * 
     * @var QuantitativeValue $weight The weight of the product.
     * 
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $weight;
    /**
     * Width
     * 
     * @var QuantitativeValue $width The width of the item.
     * 
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $width;
}
