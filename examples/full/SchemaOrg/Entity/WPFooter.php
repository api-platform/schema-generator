<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The footer section of the page.
 * 
 * @see http://schema.org/WPFooter Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WPFooter extends WebPageElement
{
}
