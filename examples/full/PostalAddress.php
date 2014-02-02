<?php

namespace SchemaOrg;

/**
 * Postal Address
 *
 * @link http://schema.org/PostalAddress
 */
class PostalAddress extends ContactPoint
{
    /**
     * Address Country
     *
     * @var Country The country. For example, USA. You can also provide the two-letter <a href="http://en.wikipedia.org/wiki/ISO_3166-1">ISO 3166-1 alpha-2 country code</a>.
     */
    protected $addressCountry;
    /**
     * Address Locality
     *
     * @var string The locality. For example, Mountain View.
     */
    protected $addressLocality;
    /**
     * Address Region
     *
     * @var string The region. For example, CA.
     */
    protected $addressRegion;
    /**
     * Postal Code
     *
     * @var string The postal code. For example, 94043.
     */
    protected $postalCode;
    /**
     * Post Office Box Number
     *
     * @var string The post offce box number for PO box addresses.
     */
    protected $postOfficeBoxNumber;
    /**
     * Street Address
     *
     * @var string The street address. For example, 1600 Amphitheatre Pkwy.
     */
    protected $streetAddress;
}
