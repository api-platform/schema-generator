<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A public structure, such as a town hall or concert hall.
 * 
 * @see http://schema.org/CivicStructure Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CivicStructure extends Place
{
    /**
     */
    private $openingHours;
}
