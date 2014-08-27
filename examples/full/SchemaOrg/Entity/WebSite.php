<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A WebSite is a set of related web pages and other items typically served from a single web domain and accessible via URLs.
 * 
 * @see http://schema.org/WebSite Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WebSite extends CreativeWork
{
}
