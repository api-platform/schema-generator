<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Defence Establishment
 * 
 * @link http://schema.org/DefenceEstablishment
 * 
 * @ORM\Entity
 */
class DefenceEstablishment extends GovernmentBuilding
{
}
