<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An historical landmark or building.
 * 
 * @see http://schema.org/LandmarksOrHistoricalBuildings Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LandmarksOrHistoricalBuildings extends Place
{
}
