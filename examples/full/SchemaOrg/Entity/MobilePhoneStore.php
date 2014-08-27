<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A store that sells mobile phones and related accessories.
 * 
 * @see http://schema.org/MobilePhoneStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MobilePhoneStore extends Store
{
}
