<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Tourist Attraction
 * 
 * @link http://schema.org/TouristAttraction
 * 
 * @ORM\Entity
 */
class TouristAttraction extends Place
{
}
