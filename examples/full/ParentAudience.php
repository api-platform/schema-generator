<?php

namespace SchemaOrg;

/**
 * Parent Audience
 *
 * @link http://schema.org/ParentAudience
 */
class ParentAudience extends PeopleAudience
{
    /**
     * Child Max Age
     *
     * @var float Maximal age of the child
     */
    protected $childMaxAge;
    /**
     * Child Min Age
     *
     * @var float Minimal age of the child
     */
    protected $childMinAge;
}
