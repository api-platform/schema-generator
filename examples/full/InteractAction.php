<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Interact Action
 * 
 * @link http://schema.org/InteractAction
 * 
 * @ORM\MappedSuperclass
 */
class InteractAction extends Action
{
}
