<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Series
 * 
 * @link http://schema.org/Series
 * 
 * @ORM\MappedSuperclass
 */
class Series extends CreativeWork
{
    /**
     * Actor
     * 
     * @var Person $actor A cast member of the movie, tv/radio series, season, episode, or video.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $actor;
    /**
     * Director
     * 
     * @var Person $director The director of the movie, tv/radio episode or series.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $director;
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
     * Music by
     * 
     * @var Person $musicBy The composer of the movie or TV/radio soundtrack.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $musicBy;
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
     * Number of Seasons
     * 
     * @var float $numberOfSeasons The number of seasons in this series.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $numberOfSeasons;
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
     * Season
     * 
     * @var Season $season A season in a tv/radio series.
     * 
     * @ORM\ManyToOne(targetEntity="Season")
     */
    private $season;
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
