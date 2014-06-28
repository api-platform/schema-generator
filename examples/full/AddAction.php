<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Add Action
 * 
 * @link http://schema.org/AddAction
 * 
 * @ORM\MappedSuperclass
 */
class AddAction extends UpdateAction
{
}
