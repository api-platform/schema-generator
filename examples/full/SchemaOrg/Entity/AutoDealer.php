<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An car dealership.
 * 
 * @see http://schema.org/AutoDealer Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AutoDealer extends AutomotiveBusiness
{
}
