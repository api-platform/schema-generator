<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An advertising section of the page.
 * 
 * @see http://schema.org/WPAdBlock Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WPAdBlock extends WebPageElement
{
}
