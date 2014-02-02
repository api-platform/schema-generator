<?php

namespace SchemaOrg;

/**
 * Contact Point
 *
 * @link http://schema.org/ContactPoint
 */
class ContactPoint extends StructuredValue
{
    /**
     * Area Served
     *
     * @var AdministrativeArea The location served by this contact point (e.g., a phone number intended for Europeans vs. North Americans or only within the United States.)
     */
    protected $areaServed;
    /**
     * Available Language
     *
     * @var Language A language someone may use with the item.
     */
    protected $availableLanguage;
    /**
     * Contact Option
     *
     * @var ContactPointOption An option available on this contact point (e.g. a toll-free number or support for hearing-impaired callers.)
     */
    protected $contactOption;
    /**
     * Contact Type
     *
     * @var string A person or organization can have different contact points, for different purposes. For example, a sales contact point, a PR contact point and so on. This property is used to specify the kind of contact point.
     */
    protected $contactType;
    /**
     * Email
     *
     * @var string Email address.
     */
    protected $email;
    /**
     * Fax Number
     *
     * @var string The fax number.
     */
    protected $faxNumber;
    /**
     * Hours Available
     *
     * @var OpeningHoursSpecification The hours during which this contact point is available.
     */
    protected $hoursAvailable;
    /**
     * Product Supported (Product)
     *
     * @var Product The product or service this support contact point is related to (such as product support for a particular product line). This can be a specific product or product line (e.g. "iPhone") or a general category of products or services (e.g. "smartphones").
     */
    protected $productSupportedProduct;
    /**
     * Product Supported (Text)
     *
     * @var string The product or service this support contact point is related to (such as product support for a particular product line). This can be a specific product or product line (e.g. "iPhone") or a general category of products or services (e.g. "smartphones").
     */
    protected $productSupportedText;
    /**
     * Telephone
     *
     * @var string The telephone number.
     */
    protected $telephone;
}
