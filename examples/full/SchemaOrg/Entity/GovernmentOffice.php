<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A government office&#x2014;for example, an IRS or DMV office.
 * 
 * @see http://schema.org/GovernmentOffice Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GovernmentOffice extends LocalBusiness
{
}
