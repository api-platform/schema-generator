<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Any bodily activity that enhances or maintains physical fitness and overall health and wellness. Includes activity that is part of daily living and routine, structured exercise, and exercise prescribed as part of a medical treatment or recovery plan.
 * 
 * @see http://schema.org/PhysicalActivity Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PhysicalActivity extends LifestyleModification
{
    /**
     * @type AnatomicalStructure $associatedAnatomy The anatomy of the underlying organ system or structures associated with this entity.
     * @ORM\ManyToOne(targetEntity="AnatomicalStructure")
     * @ORM\JoinColumn(nullable=false)
     */
    private $associatedAnatomy;
    /**
     * @type PhysicalActivityCategory $category A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     * @ORM\ManyToOne(targetEntity="PhysicalActivityCategory")
     */
    private $category;
    /**
     * @type string $epidemiology The characteristics of associated patients, such as age, gender, race etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $epidemiology;
    /**
     * @type string $pathophysiology Changes in the normal mechanical, physical, and biochemical functions that are associated with this activity or condition.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $pathophysiology;
}
