<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Courthouse
 * 
 * @link http://schema.org/Courthouse
 * 
 * @ORM\Entity
 */
class Courthouse extends GovernmentBuilding
{
}
