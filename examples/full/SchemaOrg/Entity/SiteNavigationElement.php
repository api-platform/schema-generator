<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A navigation element of the page.
 * 
 * @see http://schema.org/SiteNavigationElement Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SiteNavigationElement extends WebPageElement
{
}
