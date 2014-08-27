<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any offered product or service. For example: a pair of shoes; a concert ticket; the rental of a car; a haircut; or an episode of a TV show streamed online.
 * 
 * @see http://schema.org/Product Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Product extends Thing
{
    /**
     * @type AggregateRating $aggregateRating The overall rating, based on a collection of reviews or ratings, of the item.
     * @ORM\ManyToOne(targetEntity="AggregateRating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aggregateRating;
    /**
     * @type Audience $audience The intended audience of the item, i.e. the group for whom the item was created.
     * @ORM\ManyToOne(targetEntity="Audience")
     * @ORM\JoinColumn(nullable=false)
     */
    private $audience;
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
     * @type Distance $depth The depth of the product.
     * @ORM\OneToOne(targetEntity="Distance")
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
     * @type Distance $height The height of the item.
     * @ORM\OneToOne(targetEntity="Distance")
     */
    private $height;
    /**
     * @type Product $isAccessoryOrSparePartFor A pointer to another product (or multiple products) for which this product is an accessory or spare part.
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $isAccessoryOrSparePartFor;
    /**
     * @type Product $isConsumableFor A pointer to another product (or multiple products) for which this product is a consumable.
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $isConsumableFor;
    /**
     * @type Product $isRelatedTo A pointer to another, somehow related product (or multiple products).
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $isRelatedTo;
    /**
     * @type Product $isSimilarTo A pointer to another, functionally similar product (or multiple products).
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $isSimilarTo;
    /**
     * @type OfferItemCondition $itemCondition A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.
     * @ORM\ManyToOne(targetEntity="OfferItemCondition")
     */
    private $itemCondition;
    /**
     * @type ImageObject $logo A logo associated with an organization.
     * @ORM\ManyToOne(targetEntity="ImageObject")
     */
    private $logo;
    /**
     * @type Organization $manufacturer The manufacturer of the product.
     * @ORM\OneToOne(targetEntity="Organization")
     */
    private $manufacturer;
    /**
     * @type ProductModel $model The model of the product. Use with the URL of a ProductModel or a textual representation of the model identifier. The URL of the ProductModel can be from an external source. It is recommended to additionally provide strong product identifiers via the gtin8/gtin13/gtin14 and mpn properties.
     * @ORM\OneToOne(targetEntity="ProductModel")
     */
    private $model;
    /**
     * @type string $mpn The Manufacturer Part Number (MPN) of the product, or the product to which the offer refers.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $mpn;
    /**
     * @type Offer $offers An offer to provide this item&#x2014;for example, an offer to sell a product, rent the DVD of a movie, or give away tickets to an event.
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $offers;
    /**
     * @type string $productID The product identifier, such as ISBN. For example: <code>&lt;meta itemprop='productID' content='isbn:123-456-789'/&gt;</code>.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $productID;
    /**
     * @type \DateTime $releaseDate The release date of a product or product model. This can be used to distinguish the exact variant of a product.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $releaseDate;
    /**
     * @type Review $review A review of the item.
     * @ORM\ManyToOne(targetEntity="Review")
     */
    private $review;
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
     * @type Distance $width The width of the item.
     * @ORM\OneToOne(targetEntity="Distance")
     */
    private $width;
}
