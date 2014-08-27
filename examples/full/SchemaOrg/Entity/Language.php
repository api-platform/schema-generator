<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Natural languages such as Spanish, Tamil, Hindi, English, etc. and programming languages such as Scheme and Lisp.
 * 
 * @see http://schema.org/Language Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Language extends Intangible
{
}
