<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Professional service: Attorney.
 * 
 * @see http://schema.org/Attorney Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Attorney extends ProfessionalService
{
}
