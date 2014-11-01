<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A gym.
 * 
 * @see http://schema.org/ExerciseGym Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ExerciseGym extends SportsActivityLocation
{
}
