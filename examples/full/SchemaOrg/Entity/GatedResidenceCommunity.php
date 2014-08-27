<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Residence type: Gated community.
 * 
 * @see http://schema.org/GatedResidenceCommunity Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class GatedResidenceCommunity extends Residence
{
}
