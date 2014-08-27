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
 * Any offered product or service. For example: a pair of shoes; a concert ticket; the rental of a car; a haircut; or an episode of a TV show streamed online.
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/Product Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Product extends Thing
{
    /**
     * @type Brand $brand The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     * @ORM\ManyToOne(targetEntity="Brand")
     */
    private $brand;
    /**
     * @type string $color The color of the product.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $color;
    /**
     * @type QuantitativeValue $depth The depth of the product.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $depth;
    /**
     * @type string $gtin13 The GTIN-13 code of the product, or the product to which the offer refers. This is equivalent to 13-digit ISBN codes and EAN UCC-13. Former 12-digit UPC codes can be converted into a GTIN-13 code by simply adding a preceeding zero.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gtin13;
    /**
     * @type string $gtin14 The GTIN-14 code of the product, or the product to which the offer refers.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gtin14;
    /**
     * @type string $gtin8 The GTIN-8 code of the product, or the product to which the offer refers. This code is also known as EAN/UCC-8 or 8-digit EAN.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $gtin8;
    /**
     * @type QuantitativeValue $height The height of the item.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $height;
    /**
     * @type string $itemCondition A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $itemCondition;
    /**
     * @type string $mpn The Manufacturer Part Number (MPN) of the product, or the product to which the offer refers.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $mpn;
    /**
     * @type Offer $offers An offer to provide this item—for example, an offer to sell a product, rent the DVD of a movie, or give away tickets to an event.
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $offers;
    /**
     * @type \DateTime $releaseDate The release date of a product or product model. This can be used to distinguish the exact variant of a product.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $releaseDate;
    /**
     * @type string $sku The Stock Keeping Unit (SKU), i.e. a merchant-specific identifier for a product or service, or the product to which the offer refers.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $sku;
    /**
     * @type QuantitativeValue $weight The weight of the product.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $weight;
    /**
     * @type QuantitativeValue $width The width of the item.
     * @ORM\OneToOne(targetEntity="QuantitativeValue")
     */
    private $width;
}
