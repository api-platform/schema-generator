<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A sidebar section of the page.
 * 
 * @see http://schema.org/WPSideBar Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WPSideBar extends WebPageElement
{
}
