<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A strategy of regulating the intake of food to achieve or maintain a specific health-related goal.
 * 
 * @see http://schema.org/Diet Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Diet extends CreativeWork
{
    /**
     */
    private $dietFeatures;
    /**
     */
    private $endorsers;
    /**
     */
    private $expertConsiderations;
    /**
     */
    private $overview;
    /**
     */
    private $physiologicalBenefits;
    /**
     */
    private $proprietaryName;
    /**
     */
    private $risks;
}
