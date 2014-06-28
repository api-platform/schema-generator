<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Clip
 * 
 * @link http://schema.org/Clip
 * 
 * @ORM\MappedSuperclass
 */
class Clip extends CreativeWork
{
    /**
     * Clip Number
     * 
     * @var integer $clipNumber Position of the clip within an ordered group of clips.
     * 
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $clipNumber;
    /**
     * Part of Episode
     * 
     * @var Episode $partOfEpisode The episode to which this clip belongs.
     * 
     * @ORM\ManyToOne(targetEntity="Episode")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfEpisode;
    /**
     * Part of Season
     * 
     * @var Season $partOfSeason The season to which this episode belongs.
     * 
     * @ORM\ManyToOne(targetEntity="Season")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfSeason;
    /**
     * Part of Series
     * 
     * @var Series $partOfSeries The series to which this episode or season belongs.
     * 
     * @ORM\ManyToOne(targetEntity="Series")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfSeries;
    /**
     * Position
     * 
     * @var string $position Free text to define other than pure numerical ranking of an episode or a season in an ordered list of items (further formatting restrictions may apply within particular user groups).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $position;
    /**
     * Publication
     * 
     * @var PublicationEvent $publication A publication event associated with the episode, clip or media object.
     * 
     * @ORM\ManyToOne(targetEntity="PublicationEvent")
     */
    private $publication;
}
