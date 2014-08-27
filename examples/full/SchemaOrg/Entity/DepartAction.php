<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of  departing from a place. An agent departs from an fromLocation for a destination, optionally with participants.
 * 
 * @see http://schema.org/DepartAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DepartAction extends MoveAction
{
}
