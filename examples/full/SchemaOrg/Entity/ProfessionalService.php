<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Provider of professional services.
 * 
 * @see http://schema.org/ProfessionalService Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ProfessionalService extends LocalBusiness
{
}
