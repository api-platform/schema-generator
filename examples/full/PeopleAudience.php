<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * People Audience
 * 
 * @link http://schema.org/PeopleAudience
 * 
 * @ORM\MappedSuperclass
 */
class PeopleAudience extends Audience
{
    /**
     * Health Condition
     * 
     * @var MedicalCondition $healthCondition Expectations for health conditions of target audience
     * 
     */
    private $healthCondition;
    /**
     * Required Gender
     * 
     * @var string $requiredGender Audiences defined by a person's gender.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $requiredGender;
    /**
     * Required Max Age
     * 
     * @var integer $requiredMaxAge Audiences defined by a person's maximum age.
     * 
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $requiredMaxAge;
    /**
     * Required Min Age
     * 
     * @var integer $requiredMinAge Audiences defined by a person's minimum age.
     * 
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $requiredMinAge;
    /**
     * Suggested Gender
     * 
     * @var string $suggestedGender The gender of the person or audience.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $suggestedGender;
    /**
     * Suggested Max Age
     * 
     * @var float $suggestedMaxAge Maximal age recommended for viewing content
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $suggestedMaxAge;
    /**
     * Suggested Min Age
     * 
     * @var float $suggestedMinAge Minimal age recommended for viewing content
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $suggestedMinAge;
}
