<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Organize Action
 * 
 * @link http://schema.org/OrganizeAction
 * 
 * @ORM\MappedSuperclass
 */
class OrganizeAction extends Action
{
}
