<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An emergency service, such as a fire station or ER.
 * 
 * @see http://schema.org/EmergencyService Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class EmergencyService extends LocalBusiness
{
}
