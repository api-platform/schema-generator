<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A notary.
 * 
 * @see http://schema.org/Notary Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Notary extends ProfessionalService
{
}
