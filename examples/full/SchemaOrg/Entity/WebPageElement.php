<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A web page element, like a table or an image
 * 
 * @see http://schema.org/WebPageElement Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WebPageElement extends CreativeWork
{
}
