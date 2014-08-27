<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of accomplishing something via     previous efforts. It is an instantaneous action rather than an ongoing     process.
 * 
 * @see http://schema.org/AchieveAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AchieveAction extends Action
{
}
