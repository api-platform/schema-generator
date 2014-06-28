<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Use Action
 * 
 * @link http://schema.org/UseAction
 * 
 * @ORM\MappedSuperclass
 */
class UseAction extends ConsumeAction
{
}
