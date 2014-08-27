<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A real-estate agent.
 * 
 * @see http://schema.org/RealEstateAgent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RealEstateAgent extends LocalBusiness
{
}
