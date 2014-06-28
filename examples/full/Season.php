<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Season
 * 
 * @link http://schema.org/Season
 * 
 * @ORM\MappedSuperclass
 */
class Season extends CreativeWork
{
    /**
     * End Date
     * 
     * @var \DateTime $endDate The end date and time of the event or item (in ISO 8601 date format).
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $endDate;
    /**
     * Episode
     * 
     * @var Episode $episode An episode of a TV/radio series or season
     * 
     * @ORM\ManyToOne(targetEntity="Episode")
     */
    private $episode;
    /**
     * Number of Episodes
     * 
     * @var float $numberOfEpisodes The number of episodes in this season or series.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $numberOfEpisodes;
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
     * Producer
     * 
     * @var Person $producer The producer of the movie, tv/radio series, season, or episode, or video.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $producer;
    /**
     * Production Company
     * 
     * @var Organization $productionCompany The production company or studio that made the movie, tv/radio series, season, or episode, or media object.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productionCompany;
    /**
     * Season Number
     * 
     * @var integer $seasonNumber Position of the season within an ordered group of seasons.
     * 
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $seasonNumber;
    /**
     * Start Date
     * 
     * @var \DateTime $startDate The start date and time of the event or item (in ISO 8601 date format).
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $startDate;
    /**
     * Trailer
     * 
     * @var VideoObject $trailer The trailer of a movie or tv/radio series, season, or episode.
     * 
     * @ORM\ManyToOne(targetEntity="VideoObject")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trailer;
}
