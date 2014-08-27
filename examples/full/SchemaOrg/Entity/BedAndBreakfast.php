<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Bed and breakfast.
 * 
 * @see http://schema.org/BedAndBreakfast Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BedAndBreakfast extends LodgingBusiness
{
}
