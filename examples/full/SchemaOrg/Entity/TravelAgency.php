<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A travel agency.
 * 
 * @see http://schema.org/TravelAgency Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TravelAgency extends LocalBusiness
{
}
