<?php

namespace SchemaOrg;

/**
 * Exercise Action
 *
 * @link http://schema.org/ExerciseAction
 */
class ExerciseAction extends PlayAction
{
    /**
     * Course
     *
     * @var Place A sub property of location. The course where this action was taken.
     */
    protected $course;
    /**
     * Diet
     *
     * @var Diet A sub property of instrument. The died used in this action.
     */
    protected $diet;
    /**
     * Distance
     *
     * @var Distance A sub property of asset. The distance travelled.
     */
    protected $distance;
    /**
     * Exercise Plan
     *
     * @var ExercisePlan A sub property of instrument. The exercise plan used on this action.
     */
    protected $exercisePlan;
    /**
     * Exercise Type
     *
     * @var string Type(s) of exercise or activity, such as strength training, flexibility training, aerobics, cardiac rehabilitation, etc.
     */
    protected $exerciseType;
    /**
     * From Location (Place)
     *
     * @var Place A sub property of location. The original location of the object or the agent before the action.
     */
    protected $fromLocationPlace;
    /**
     * From Location (Number)
     *
     * @var float A sub property of location. The original location of the object or the agent before the action.
     */
    protected $fromLocationNumber;
    /**
     * Oponent
     *
     * @var Person A sub property of participant. The oponent on this action.
     */
    protected $oponent;
    /**
     * Sports Activity Location
     *
     * @var SportsActivityLocation A sub property of location. The sports activity location where this action occurred.
     */
    protected $sportsActivityLocation;
    /**
     * Sports Event
     *
     * @var SportsEvent A sub property of location. The sports event where this action occurred.
     */
    protected $sportsEvent;
    /**
     * Sports Team
     *
     * @var SportsTeam A sub property of participant. The sports team that participated on this action.
     */
    protected $sportsTeam;
    /**
     * To Location (Place)
     *
     * @var Place A sub property of location. The final location of the object or the agent after the action.
     */
    protected $toLocationPlace;
    /**
     * To Location (Number)
     *
     * @var float A sub property of location. The final location of the object or the agent after the action.
     */
    protected $toLocationNumber;
}
