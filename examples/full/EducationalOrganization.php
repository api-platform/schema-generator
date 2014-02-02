<?php

namespace SchemaOrg;

/**
 * Educational Organization
 *
 * @link http://schema.org/EducationalOrganization
 */
class EducationalOrganization extends Organization
{
    /**
     * Alumni
     *
     * @var Person Alumni of educational organization.
     */
    protected $alumni;
}
