<?php

namespace SchemaOrg;

/**
 * Ownership Info
 *
 * @link http://schema.org/OwnershipInfo
 */
class OwnershipInfo extends StructuredValue
{
    /**
     * Acquired From (Organization)
     *
     * @var Organization The organization or person from which the product was acquired.
     */
    protected $acquiredFromOrganization;
    /**
     * Acquired From (Person)
     *
     * @var Person The organization or person from which the product was acquired.
     */
    protected $acquiredFromPerson;
    /**
     * Owned From
     *
     * @var \DateTime The date and time of obtaining the product.
     */
    protected $ownedFrom;
    /**
     * Owned Through
     *
     * @var \DateTime The date and time of giving up ownership on the product.
     */
    protected $ownedThrough;
    /**
     * Type of Good
     *
     * @var Product The product that this structured value is referring to.
     */
    protected $typeOfGood;
}
