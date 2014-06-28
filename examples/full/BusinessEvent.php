<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Business Event
 * 
 * @link http://schema.org/BusinessEvent
 * 
 * @ORM\Entity
 */
class BusinessEvent extends Event
{
}
