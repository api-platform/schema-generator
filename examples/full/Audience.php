<?php

namespace SchemaOrg;

/**
 * Audience
 *
 * @link http://schema.org/Audience
 */
class Audience extends Intangible
{
    /**
     * Audience Type
     *
     * @var string The target group associated with a given audience (e.g. veterans, car owners, musicians, etc.)
      domain: Audience
      Range: Text

     */
    protected $audienceType;
    /**
     * Geographic Area
     *
     * @var AdministrativeArea The geographic area associated with the audience.
     */
    protected $geographicArea;
}
