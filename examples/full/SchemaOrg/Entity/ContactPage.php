<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Web page type: Contact page.
 * 
 * @see http://schema.org/ContactPage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ContactPage extends WebPage
{
}
