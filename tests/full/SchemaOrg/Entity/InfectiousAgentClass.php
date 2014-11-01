<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Classes of agents or pathogens that transmit infectious diseases. Enumerated type.
 * 
 * @see http://schema.org/InfectiousAgentClass Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class InfectiousAgentClass extends MedicalEnumeration
{
}
