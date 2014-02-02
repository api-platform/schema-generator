<?php

namespace SchemaOrg;

/**
 * Product
 *
 * @link http://schema.org/Product
 */
class Product extends Thing
{
    /**
     * Aggregate Rating
     *
     * @var AggregateRating The overall rating, based on a collection of reviews or ratings, of the item.
     */
    protected $aggregateRating;
    /**
     * Audience
     *
     * @var Audience The intended audience of the item, i.e. the group for whom the item was created.
     */
    protected $audience;
    /**
     * Brand (Organization)
     *
     * @var Organization The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     */
    protected $brandOrganization;
    /**
     * Brand (Brand)
     *
     * @var Brand The brand(s) associated with a product or service, or the brand(s) maintained by an organization or business person.
     */
    protected $brandBrand;
    /**
     * Color
     *
     * @var string The color of the product.
     */
    protected $color;
    /**
     * Depth (Distance)
     *
     * @var Distance The depth of the product.
     */
    protected $depthDistance;
    /**
     * Depth (QuantitativeValue)
     *
     * @var QuantitativeValue The depth of the product.
     */
    protected $depthQuantitativeValue;
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
     * Height (Distance)
     *
     * @var Distance The height of the item.
     */
    protected $heightDistance;
    /**
     * Height (QuantitativeValue)
     *
     * @var QuantitativeValue The height of the item.
     */
    protected $heightQuantitativeValue;
    /**
     * Is Accessory or Spare Part for
     *
     * @var Product A pointer to another product (or multiple products) for which this product is an accessory or spare part.
     */
    protected $isAccessoryOrSparePartFor;
    /**
     * Is Consumable for
     *
     * @var Product A pointer to another product (or multiple products) for which this product is a consumable.
     */
    protected $isConsumableFor;
    /**
     * Is Related to
     *
     * @var Product A pointer to another, somehow related product (or multiple products).
     */
    protected $isRelatedTo;
    /**
     * Is Similar to
     *
     * @var Product A pointer to another, functionally similar product (or multiple products).
     */
    protected $isSimilarTo;
    /**
     * Item Condition
     *
     * @var OfferItemCondition A predefined value from OfferItemCondition or a textual description of the condition of the product or service, or the products or services included in the offer.
     */
    protected $itemCondition;
    /**
     * Logo (URL)
     *
     * @var string A logo associated with an organization.
     */
    protected $logoURL;
    /**
     * Logo (ImageObject)
     *
     * @var ImageObject A logo associated with an organization.
     */
    protected $logoImageObject;
    /**
     * Manufacturer
     *
     * @var Organization The manufacturer of the product.
     */
    protected $manufacturer;
    /**
     * Model (ProductModel)
     *
     * @var ProductModel The model of the product. Use with the URL of a ProductModel or a textual representation of the model identifier. The URL of the ProductModel can be from an external source. It is recommended to additionally provide strong product identifiers via the gtin8/gtin13/gtin14 and mpn properties.
     */
    protected $modelProductModel;
    /**
     * Model (Text)
     *
     * @var string The model of the product. Use with the URL of a ProductModel or a textual representation of the model identifier. The URL of the ProductModel can be from an external source. It is recommended to additionally provide strong product identifiers via the gtin8/gtin13/gtin14 and mpn properties.
     */
    protected $modelText;
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
     * Product ID
     *
     * @var string The product identifier, such as ISBN. For example: <code>&lt;meta itemprop='productID' content='isbn:123-456-789'/&gt;</code>.
     */
    protected $productID;
    /**
     * Release Date
     *
     * @var \DateTime The release date of a product or product model. This can be used to distinguish the exact variant of a product.
     */
    protected $releaseDate;
    /**
     * Review
     *
     * @var Review A review of the item.
     */
    protected $review;
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
     * Width (Distance)
     *
     * @var Distance The width of the item.
     */
    protected $widthDistance;
    /**
     * Width (QuantitativeValue)
     *
     * @var QuantitativeValue The width of the item.
     */
    protected $widthQuantitativeValue;
}
