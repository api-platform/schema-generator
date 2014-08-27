<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of installing an application.
 * 
 * @see http://schema.org/InstallAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class InstallAction extends ConsumeAction
{
}
