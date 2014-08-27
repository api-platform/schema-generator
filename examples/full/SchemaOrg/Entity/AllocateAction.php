<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of organizing tasks/objects/events by associating resources to it.
 * 
 * @see http://schema.org/AllocateAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AllocateAction extends OrganizeAction
{
    /**
     * @type MedicalDevicePurpose $purpose A goal towards an action is taken. Can be concrete or abstract.
     * @ORM\ManyToOne(targetEntity="MedicalDevicePurpose")
     */
    private $purpose;
}
