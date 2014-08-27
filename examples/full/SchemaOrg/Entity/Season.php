<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A TV or radio season.
 * 
 * @see http://schema.org/Season Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Season extends CreativeWork
{
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
     * @type float $numberOfEpisodes The number of episodes in this season or series.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $numberOfEpisodes;
    /**
     * @type Series $partOfSeries The series to which this episode or season belongs.
     * @ORM\ManyToOne(targetEntity="Series")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfSeries;
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
     * @type integer $seasonNumber Position of the season within an ordered group of seasons.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $seasonNumber;
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
