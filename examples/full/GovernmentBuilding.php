<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Government Building
 * 
 * @link http://schema.org/GovernmentBuilding
 * 
 * @ORM\MappedSuperclass
 */
class GovernmentBuilding extends CivicStructure
{
}
