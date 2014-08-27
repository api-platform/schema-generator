<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Series dedicated to TV broadcast and associated online delivery.
 * 
 * @see http://schema.org/TVSeries Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TVSeries extends CreativeWork
{
    /**
     * @type Person $actor A cast member of the movie, tv/radio series, season, episode, or video.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $actor;
    /**
     * @type Person $director The director of the movie, tv/radio episode or series.
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $director;
    /**
     * @type \DateTime $endDate The end date and time of the role, event or item (in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 date format</a>).
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $endDate;
    /**
     * @type Episode $episode An episode of a TV/radio series or season
     * @ORM\ManyToOne(targetEntity="Episode")
     */
    private $episode;
    /**
     * @type MusicGroup $musicBy The composer of the movie or TV/radio soundtrack.
     * @ORM\ManyToOne(targetEntity="MusicGroup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $musicBy;
    /**
     * @type float $numberOfEpisodes The number of episodes in this season or series.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $numberOfEpisodes;
    /**
     * @type Person $producer The producer of the movie, tv/radio series, season, or episode, or video.
     * @ORM\ManyToOne(targetEntity="Person")
     * @ORM\JoinColumn(nullable=false)
     */
    private $producer;
    /**
     * @type Organization $productionCompany The production company or studio that made the movie, tv/radio series, season, or episode, or media object.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productionCompany;
    /**
     * @type Season $season A season in a tv/radio series.
     * @ORM\ManyToOne(targetEntity="Season")
     */
    private $season;
    /**
     * @type \DateTime $startDate The start date and time of the event, role or item (in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 date format</a>).
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $startDate;
    /**
     * @type VideoObject $trailer The trailer of a movie or tv/radio series, season, or episode.
     * @ORM\ManyToOne(targetEntity="VideoObject")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trailer;
}
