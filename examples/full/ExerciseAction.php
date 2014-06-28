<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Exercise Action
 * 
 * @link http://schema.org/ExerciseAction
 * 
 * @ORM\Entity
 */
class ExerciseAction extends PlayAction
{
    /**
     * Course
     * 
     * @var Place $course A sub property of location. The course where this action was taken.
     * 
     * @ORM\ManyToOne(targetEntity="Place")
     */
    private $course;
    /**
     * Diet
     * 
     * @var Diet $diet A sub property of instrument. The died used in this action.
     * 
     * @ORM\ManyToOne(targetEntity="Diet")
     */
    private $diet;
    /**
     * Distance
     * 
     * @var Distance $distance A sub property of asset. The distance travelled.
     * 
     * @ORM\ManyToOne(targetEntity="Distance")
     */
    private $distance;
    /**
     * Exercise Plan
     * 
     * @var ExercisePlan $exercisePlan A sub property of instrument. The exercise plan used on this action.
     * 
     * @ORM\ManyToOne(targetEntity="ExercisePlan")
     */
    private $exercisePlan;
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
     * From Location
     * 
     * @var Place $fromLocation A sub property of location. The original location of the object or the agent before the action.
     * 
     * @ORM\ManyToOne(targetEntity="Place")
     */
    private $fromLocation;
    /**
     * Oponent
     * 
     * @var Person $oponent A sub property of participant. The oponent on this action.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $oponent;
    /**
     * Sports Activity Location
     * 
     * @var SportsActivityLocation $sportsActivityLocation A sub property of location. The sports activity location where this action occurred.
     * 
     * @ORM\ManyToOne(targetEntity="SportsActivityLocation")
     */
    private $sportsActivityLocation;
    /**
     * Sports Event
     * 
     * @var SportsEvent $sportsEvent A sub property of location. The sports event where this action occurred.
     * 
     * @ORM\ManyToOne(targetEntity="SportsEvent")
     */
    private $sportsEvent;
    /**
     * Sports Team
     * 
     * @var SportsTeam $sportsTeam A sub property of participant. The sports team that participated on this action.
     * 
     * @ORM\ManyToOne(targetEntity="SportsTeam")
     */
    private $sportsTeam;
    /**
     * To Location
     * 
     * @var Place $toLocation A sub property of location. The final location of the object or the agent after the action.
     * 
     * @ORM\ManyToOne(targetEntity="Place")
     */
    private $toLocation;
}
