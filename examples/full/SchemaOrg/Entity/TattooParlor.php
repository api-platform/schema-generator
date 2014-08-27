<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A tattoo parlor.
 * 
 * @see http://schema.org/TattooParlor Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TattooParlor extends HealthAndBeautyBusiness
{
}
