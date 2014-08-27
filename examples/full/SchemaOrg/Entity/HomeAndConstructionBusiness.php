<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A construction business.
 * 
 * @see http://schema.org/HomeAndConstructionBusiness Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class HomeAndConstructionBusiness extends LocalBusiness
{
}
