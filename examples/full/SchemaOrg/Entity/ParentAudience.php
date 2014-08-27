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
     * @type float $childMaxAge Maximal age of the child
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $childMaxAge;
    /**
     * @type float $childMinAge Minimal age of the child
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $childMinAge;
}
