<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An internet cafe.
 * 
 * @see http://schema.org/InternetCafe Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class InternetCafe extends LocalBusiness
{
}
