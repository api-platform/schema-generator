<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Web page type: Profile page.
 * 
 * @see http://schema.org/ProfilePage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ProfilePage extends WebPage
{
}
