<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Legislative Building
 * 
 * @link http://schema.org/LegislativeBuilding
 * 
 * @ORM\Entity
 */
class LegislativeBuilding extends GovernmentBuilding
{
}
