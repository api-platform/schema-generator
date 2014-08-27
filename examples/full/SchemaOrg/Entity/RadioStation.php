<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A radio station.
 * 
 * @see http://schema.org/RadioStation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RadioStation extends LocalBusiness
{
}
