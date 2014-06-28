<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Consume Action
 * 
 * @link http://schema.org/ConsumeAction
 * 
 * @ORM\MappedSuperclass
 */
class ConsumeAction extends Action
{
}
