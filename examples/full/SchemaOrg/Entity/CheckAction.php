<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An agent inspects/determines/investigates/inquire or examine an object's accuracy/quality/condition or state.
 * 
 * @see http://schema.org/CheckAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CheckAction extends FindAction
{
}
