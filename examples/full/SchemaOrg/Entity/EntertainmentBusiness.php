<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A business providing entertainment.
 * 
 * @see http://schema.org/EntertainmentBusiness Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class EntertainmentBusiness extends LocalBusiness
{
}
