<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A set of characteristics describing parents, who can be interested in viewing some content
 * 
 * @see http://schema.org/ParentAudience Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ParentAudience extends PeopleAudience
{
    /**
     */
    private $childMaxAge;
    /**
     */
    private $childMinAge;
}
