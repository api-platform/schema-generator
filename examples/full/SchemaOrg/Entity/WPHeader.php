<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The header section of the page.
 * 
 * @see http://schema.org/WPHeader Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WPHeader extends WebPageElement
{
}
