<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A set of characteristics belonging to people, e.g. who compose an item's target audience.
 * 
 * @see http://schema.org/PeopleAudience Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PeopleAudience extends Audience
{
    /**
     * @type MedicalCondition $healthCondition Expectations for health conditions of target audience
     */
    private $healthCondition;
    /**
     * @type string $requiredGender Audiences defined by a person's gender.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $requiredGender;
    /**
     * @type integer $requiredMaxAge Audiences defined by a person's maximum age.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $requiredMaxAge;
    /**
     * @type integer $requiredMinAge Audiences defined by a person's minimum age.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $requiredMinAge;
    /**
     * @type string $suggestedGender The gender of the person or audience.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $suggestedGender;
    /**
     * @type float $suggestedMaxAge Maximal age recommended for viewing content.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $suggestedMaxAge;
    /**
     * @type float $suggestedMinAge Minimal age recommended for viewing content.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $suggestedMinAge;
}
