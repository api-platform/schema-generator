<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of arriving at a place. An agent arrives at a destination from an fromLocation, optionally with participants.
 * 
 * @see http://schema.org/ArriveAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ArriveAction extends MoveAction
{
}
