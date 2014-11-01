<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of achieving victory in a competitive activity.
 * 
 * @see http://schema.org/WinAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WinAction extends AchieveAction
{
    /**
     */
    private $loser;
}
