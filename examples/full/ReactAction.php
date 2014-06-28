<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * React Action
 * 
 * @link http://schema.org/ReactAction
 * 
 * @ORM\MappedSuperclass
 */
class ReactAction extends AssessAction
{
}
