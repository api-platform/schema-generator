<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An EducationalAudience
 * 
 * @see http://schema.org/EducationalAudience Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class EducationalAudience extends Audience
{
    /**
     * @type string $educationalRole An educationalRole of an EducationalAudience
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $educationalRole;
}
