<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of participating in exertive activity for the purposes of improving health and fitness
 * 
 * @see http://schema.org/ExerciseAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ExerciseAction extends PlayAction
{
    /**
     * @type Place $course A sub property of location. The course where this action was taken.
     * @ORM\ManyToOne(targetEntity="Place")
     */
    private $course;
    /**
     * @type Diet $diet A sub property of instrument. The diet used in this action.
     * @ORM\ManyToOne(targetEntity="Diet")
     */
    private $diet;
    /**
     * @type Distance $distance The distance travelled, e.g. exercising or travelling.
     * @ORM\ManyToOne(targetEntity="Distance")
     * @ORM\JoinColumn(nullable=false)
     */
    private $distance;
    /**
     * @type ExercisePlan $exercisePlan A sub property of instrument. The exercise plan used on this action.
     * @ORM\ManyToOne(targetEntity="ExercisePlan")
     */
    private $exercisePlan;
    /**
     * @type string $exerciseType Type(s) of exercise or activity, such as strength training, flexibility training, aerobics, cardiac rehabilitation, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $exerciseType;
    /**
     * @type float $fromLocation A sub property of location. The original location of the object or the agent before the action.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $fromLocation;
    /**
     * @type Person $opponent A sub property of participant. The opponent on this action.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $opponent;
    /**
     * @type SportsActivityLocation $sportsActivityLocation A sub property of location. The sports activity location where this action occurred.
     * @ORM\ManyToOne(targetEntity="SportsActivityLocation")
     */
    private $sportsActivityLocation;
    /**
     * @type SportsEvent $sportsEvent A sub property of location. The sports event where this action occurred.
     * @ORM\ManyToOne(targetEntity="SportsEvent")
     */
    private $sportsEvent;
    /**
     * @type SportsTeam $sportsTeam A sub property of participant. The sports team that participated on this action.
     * @ORM\ManyToOne(targetEntity="SportsTeam")
     */
    private $sportsTeam;
    /**
     * @type float $toLocation A sub property of location. The final location of the object or the agent after the action.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $toLocation;
}
