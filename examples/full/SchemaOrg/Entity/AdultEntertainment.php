<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An adult entertainment establishment.
 * 
 * @see http://schema.org/AdultEntertainment Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AdultEntertainment extends EntertainmentBusiness
{
}
