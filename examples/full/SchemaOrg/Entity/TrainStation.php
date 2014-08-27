<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A train station.
 * 
 * @see http://schema.org/TrainStation Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TrainStation extends CivicStructure
{
}
