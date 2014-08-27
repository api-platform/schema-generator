<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A tourist information center.
 * 
 * @see http://schema.org/TouristInformationCenter Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TouristInformationCenter extends LocalBusiness
{
}
