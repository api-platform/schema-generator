<?php

namespace SchemaOrg;

/**
 * Physical Activity
 *
 * @link http://schema.org/PhysicalActivity
 */
class PhysicalActivity extends LifestyleModification
{
    /**
     * Associated Anatomy (AnatomicalSystem)
     *
     * @var AnatomicalSystem The anatomy of the underlying organ system or structures associated with this entity.
     */
    protected $associatedAnatomyAnatomicalSystem;
    /**
     * Associated Anatomy (SuperficialAnatomy)
     *
     * @var SuperficialAnatomy The anatomy of the underlying organ system or structures associated with this entity.
     */
    protected $associatedAnatomySuperficialAnatomy;
    /**
     * Associated Anatomy (AnatomicalStructure)
     *
     * @var AnatomicalStructure The anatomy of the underlying organ system or structures associated with this entity.
     */
    protected $associatedAnatomyAnatomicalStructure;
    /**
     * Category (Text)
     *
     * @var string A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     */
    protected $categoryText;
    /**
     * Category (PhysicalActivityCategory)
     *
     * @var PhysicalActivityCategory A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     */
    protected $categoryPhysicalActivityCategory;
    /**
     * Category (Thing)
     *
     * @var Thing A category for the item. Greater signs or slashes can be used to informally indicate a category hierarchy.
     */
    protected $categoryThing;
    /**
     * Epidemiology
     *
     * @var string The characteristics of associated patients, such as age, gender, race etc.
     */
    protected $epidemiology;
    /**
     * Pathophysiology
     *
     * @var string Changes in the normal mechanical, physical, and biochemical functions that are associated with this activity or condition.
     */
    protected $pathophysiology;
}
