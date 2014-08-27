<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any anatomical structure which pertains to the soft nervous tissue functioning as the coordinating center of sensation and intellectual and nervous activity.
 * 
 * @see http://schema.org/BrainStructure Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BrainStructure extends AnatomicalStructure
{
}
