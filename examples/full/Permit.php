<?php

namespace SchemaOrg;

/**
 * Permit
 *
 * @link http://schema.org/Permit
 */
class Permit extends Intangible
{
    /**
     * Issued by
     *
     * @var Organization The organization issuing the permit.
     */
    protected $issuedBy;
    /**
     * Issued Through
     *
     * @var Service The service through with the permit was granted.
     */
    protected $issuedThrough;
    /**
     * Permit Audience
     *
     * @var Audience The target audience for this permit.
     */
    protected $permitAudience;
    /**
     * Valid for
     *
     * @var Duration The time validity of the permit.
     */
    protected $validFor;
    /**
     * Valid From
     *
     * @var \DateTime The date when the item becomes valid.
     */
    protected $validFrom;
    /**
     * Valid in
     *
     * @var AdministrativeArea The geographic area where the permit is valid.
     */
    protected $validIn;
    /**
     * Valid Until
     *
     * @var \DateTime The date when the item is no longer valid.
     */
    protected $validUntil;
}
