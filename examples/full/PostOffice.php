<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Post Office
 * 
 * @link http://schema.org/PostOffice
 * 
 * @ORM\Entity
 */
class PostOffice extends GovernmentOffice
{
}
