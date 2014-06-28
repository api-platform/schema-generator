<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Parent Audience
 * 
 * @link http://schema.org/ParentAudience
 * 
 * @ORM\Entity
 */
class ParentAudience extends PeopleAudience
{
    /**
     * Child Max Age
     * 
     * @var float $childMaxAge Maximal age of the child
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $childMaxAge;
    /**
     * Child Min Age
     * 
     * @var float $childMinAge Minimal age of the child
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $childMinAge;
}
