<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Create Action
 * 
 * @link http://schema.org/CreateAction
 * 
 * @ORM\MappedSuperclass
 */
class CreateAction extends Action
{
}
