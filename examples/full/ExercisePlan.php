<?php

namespace SchemaOrg;

/**
 * Exercise Plan
 *
 * @link http://schema.org/ExercisePlan
 */
class ExercisePlan extends CreativeWork
{
    /**
     * Activity Duration
     *
     * @var Duration Length of time to engage in the activity.
     */
    protected $activityDuration;
    /**
     * Activity Frequency
     *
     * @var string How often one should engage in the activity.
     */
    protected $activityFrequency;
    /**
     * Additional Variable
     *
     * @var string Any additional component of the exercise prescription that may need to be articulated to the patient. This may include the order of exercises, the number of repetitions of movement, quantitative distance, progressions over time, etc.
     */
    protected $additionalVariable;
    /**
     * Exercise Type
     *
     * @var string Type(s) of exercise or activity, such as strength training, flexibility training, aerobics, cardiac rehabilitation, etc.
     */
    protected $exerciseType;
    /**
     * Intensity
     *
     * @var string Quantitative measure gauging the degree of force involved in the exercise, for example, heartbeats per minute. May include the velocity of the movement.
     */
    protected $intensity;
    /**
     * Repetitions
     *
     * @var float Number of times one should repeat the activity.
     */
    protected $repetitions;
    /**
     * Rest Periods
     *
     * @var string How often one should break from the activity.
     */
    protected $restPeriods;
    /**
     * Workload
     *
     * @var Energy Quantitative measure of the physiologic output of the exercise; also referred to as energy expenditure.
     */
    protected $workload;
}
