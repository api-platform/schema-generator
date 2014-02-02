<?php

namespace SchemaOrg;

/**
 * Brand
 *
 * @link http://schema.org/Brand
 */
class Brand extends Intangible
{
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
}
