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
     */
    private $associatedAnatomy;
    /**
     */
    private $category;
    /**
     */
    private $epidemiology;
    /**
     */
    private $pathophysiology;
}
