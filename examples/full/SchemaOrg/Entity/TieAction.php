<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of reaching a draw in a competitive activity.
 * 
 * @see http://schema.org/TieAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TieAction extends AchieveAction
{
}
