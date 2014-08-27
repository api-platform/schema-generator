<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Web page type: About page.
 * 
 * @see http://schema.org/AboutPage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AboutPage extends WebPage
{
}
