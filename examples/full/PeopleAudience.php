<?php

namespace SchemaOrg;

/**
 * People Audience
 *
 * @link http://schema.org/PeopleAudience
 */
class PeopleAudience extends Audience
{
    /**
     * Health Condition
     *
     * @var MedicalCondition Expectations for health conditions of target audience
     */
    protected $healthCondition;
    /**
     * Required Gender
     *
     * @var string Audiences defined by a person's gender.
     */
    protected $requiredGender;
    /**
     * Required Max Age
     *
     * @var integer Audiences defined by a person's maximum age.
     */
    protected $requiredMaxAge;
    /**
     * Required Min Age
     *
     * @var integer Audiences defined by a person's minimum age.
     */
    protected $requiredMinAge;
    /**
     * Suggested Gender
     *
     * @var string The gender of the person or audience.
     */
    protected $suggestedGender;
    /**
     * Suggested Max Age
     *
     * @var float Maximal age recommended for viewing content
     */
    protected $suggestedMaxAge;
    /**
     * Suggested Min Age
     *
     * @var float Minimal age recommended for viewing content
     */
    protected $suggestedMinAge;
}
