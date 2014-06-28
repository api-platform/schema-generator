<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Duration
 * 
 * @link http://schema.org/Duration
 * 
 * @ORM\Entity
 */
class Duration extends Quantity
{
}
