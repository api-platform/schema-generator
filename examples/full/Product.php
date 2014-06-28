<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 * 
 * @link http://schema.org/Product
 * 
 * @ORM\MappedSuperclass
 */
class Product extends Thing
{
    /**
     * Aggregate Rating
     * 
     * @var AggregateRating $aggregateRating The overall rating, based on a collection of reviews or ratings, of the item.
     * 
     * @ORM\ManyToOne(targetEntity="AggregateRating")
     * @ORM\JoinColumn(nullable=false)
     */
    private $aggregateRating;
    /**
     * Audience
     * 
     * @var Audience $audience The intended audience of the item, i.e. the group for whom the item was created.
     * 
     * @ORM\ManyToOne(targetEntity="Audience")
     * @ORM\JoinColumn(nullable=false)
     */
    private $audience;
    /**
     * Brand
     * 
     * @var Organization $brand The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
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
     * @var Distance $depth The depth of the product.
     * 
     * @ORM\OneToOne(targetEntity="Distance")
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
     * @var Distance $height The height of the item.
     * 
     * @ORM\OneToOne(targetEntity="Distance")
     */
    private $height;
    /**
     * Is Accessory or Spare Part for
     * 
     * @var Product $isAccessoryOrSparePartFor A pointer to another product (or multiple products) for which this product is an accessory or spare part.
     * 
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $isAccessoryOrSparePartFor;
    /**
     * Is Consumable for
     * 
     * @var Product $isConsumableFor A pointer to another product (or multiple products) for which this product is a consumable.
     * 
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $isConsumableFor;
    /**
     * Is Related to
     * 
     * @var Product $isRelatedTo A pointer to another, somehow related product (or multiple products).
     * 
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $isRelatedTo;
    /**
     * Is Similar to
     * 
     * @var Product $isSimilarTo A pointer to another, functionally similar product (or multiple products).
     * 
     * @ORM\ManyToOne(targetEntity="Product")
     */
    private $isSimilarTo;
    /**
     * Item Condition
     * 
     * @var OfferItemCondition $itemCondition A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.
     * 
     * @ORM\ManyToOne(targetEntity="OfferItemCondition")
     */
    private $itemCondition;
    /**
     * Logo
     * 
     * @var string $logo A logo associated with an organization.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $logo;
    /**
     * Manufacturer
     * 
     * @var Organization $manufacturer The manufacturer of the product.
     * 
     * @ORM\OneToOne(targetEntity="Organization")
     */
    private $manufacturer;
    /**
     * Model
     * 
     * @var ProductModel $model The model of the product. Use with the URL of a ProductModel or a textual representation of the model identifier. The URL of the ProductModel can be from an external source. It is recommended to additionally provide strong product identifiers via the gtin8/gtin13/gtin14 and mpn properties.
     * 
     * @ORM\OneToOne(targetEntity="ProductModel")
     */
    private $model;
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
     * Product ID
     * 
     * @var string $productID The product identifier, such as ISBN. For example: <meta itemprop='productID' content='isbn:123-456-789'/>.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $productID;
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
     * Review
     * 
     * @var Review $review A review of the item.
     * 
     * @ORM\ManyToOne(targetEntity="Review")
     */
    private $review;
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
     * @var Distance $width The width of the item.
     * 
     * @ORM\OneToOne(targetEntity="Distance")
     */
    private $width;
}
