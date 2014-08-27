<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Fitness-related activity designed for a specific health-related purpose, including defined exercise routines as well as activity prescribed by a clinician.
 * 
 * @see http://schema.org/ExercisePlan Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ExercisePlan extends CreativeWork
{
    /**
     * @type Duration $activityDuration Length of time to engage in the activity.
     */
    private $activityDuration;
    /**
     * @type string $activityFrequency How often one should engage in the activity.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $activityFrequency;
    /**
     * @type string $additionalVariable Any additional component of the exercise prescription that may need to be articulated to the patient. This may include the order of exercises, the number of repetitions of movement, quantitative distance, progressions over time, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $additionalVariable;
    /**
     * @type string $exerciseType Type(s) of exercise or activity, such as strength training, flexibility training, aerobics, cardiac rehabilitation, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $exerciseType;
    /**
     * @type string $intensity Quantitative measure gauging the degree of force involved in the exercise, for example, heartbeats per minute. May include the velocity of the movement.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $intensity;
    /**
     * @type float $repetitions Number of times one should repeat the activity.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $repetitions;
    /**
     * @type string $restPeriods How often one should break from the activity.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $restPeriods;
    /**
     * @type Energy $workload Quantitative measure of the physiologic output of the exercise; also referred to as energy expenditure.
     */
    private $workload;
}
