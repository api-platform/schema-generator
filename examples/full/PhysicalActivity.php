<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Physical Activity
 * 
 * @link http://schema.org/PhysicalActivity
 * 
 * @ORM\MappedSuperclass
 */
class PhysicalActivity extends LifestyleModification
{
    /**
     * Associated Anatomy
     * 
     * @var AnatomicalSystem $associatedAnatomy The anatomy of the underlying organ system or structures associated with this entity.
     * 
     * @ORM\ManyToOne(targetEntity="AnatomicalSystem")
     * @ORM\JoinColumn(nullable=false)
     */
    private $associatedAnatomy;
    /**
     * Category
     * 
     * @var string $category A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $category;
    /**
     * Epidemiology
     * 
     * @var string $epidemiology The characteristics of associated patients, such as age, gender, race etc.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $epidemiology;
    /**
     * Pathophysiology
     * 
     * @var string $pathophysiology Changes in the normal mechanical, physical, and biochemical functions that are associated with this activity or condition.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $pathophysiology;
}
