<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A dry-cleaning business.
 * 
 * @see http://schema.org/DryCleaningOrLaundry Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DryCleaningOrLaundry extends LocalBusiness
{
}
