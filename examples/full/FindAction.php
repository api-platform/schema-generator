<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Find Action
 * 
 * @link http://schema.org/FindAction
 * 
 * @ORM\MappedSuperclass
 */
class FindAction extends Action
{
}
