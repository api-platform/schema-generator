<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Landmarks or Historical Buildings
 * 
 * @link http://schema.org/LandmarksOrHistoricalBuildings
 * 
 * @ORM\Entity
 */
class LandmarksOrHistoricalBuildings extends Place
{
}
