<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A defence establishment, such as an army or navy base.
 * 
 * @see http://schema.org/DefenceEstablishment Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DefenceEstablishment extends GovernmentBuilding
{
}
