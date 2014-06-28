<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Educational Audience
 * 
 * @link http://schema.org/EducationalAudience
 * 
 * @ORM\Entity
 */
class EducationalAudience extends Audience
{
    /**
     * Educational Role
     * 
     * @var string $educationalRole An educationalRole of an EducationalAudience
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $educationalRole;
}
