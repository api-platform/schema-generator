<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Exercise Gym
 * 
 * @link http://schema.org/ExerciseGym
 * 
 * @ORM\Entity
 */
class ExerciseGym extends SportsActivityLocation
{
}
