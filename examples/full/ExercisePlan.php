<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Exercise Plan
 * 
 * @link http://schema.org/ExercisePlan
 * 
 * @ORM\Entity
 */
class ExercisePlan extends CreativeWork
{
    /**
     * Activity Duration
     * 
     * @var Duration $activityDuration Length of time to engage in the activity.
     * 
     */
    private $activityDuration;
    /**
     * Activity Frequency
     * 
     * @var string $activityFrequency How often one should engage in the activity.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $activityFrequency;
    /**
     * Additional Variable
     * 
     * @var string $additionalVariable Any additional component of the exercise prescription that may need to be articulated to the patient. This may include the order of exercises, the number of repetitions of movement, quantitative distance, progressions over time, etc.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $additionalVariable;
    /**
     * Exercise Type
     * 
     * @var string $exerciseType Type(s) of exercise or activity, such as strength training, flexibility training, aerobics, cardiac rehabilitation, etc.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $exerciseType;
    /**
     * Intensity
     * 
     * @var string $intensity Quantitative measure gauging the degree of force involved in the exercise, for example, heartbeats per minute. May include the velocity of the movement.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $intensity;
    /**
     * Repetitions
     * 
     * @var float $repetitions Number of times one should repeat the activity.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $repetitions;
    /**
     * Rest Periods
     * 
     * @var string $restPeriods How often one should break from the activity.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $restPeriods;
    /**
     * Workload
     * 
     * @var Energy $workload Quantitative measure of the physiologic output of the exercise; also referred to as energy expenditure.
     * 
     */
    private $workload;
}
