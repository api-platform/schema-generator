<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A TV episode which can be part of a series or season.
 * 
 * @see http://schema.org/TVEpisode Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TVEpisode extends Episode
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
     * @type MusicGroup $musicBy The composer of the movie or TV/radio soundtrack.
     * @ORM\ManyToOne(targetEntity="MusicGroup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $musicBy;
    /**
     * @type Season $partOfSeason The season to which this episode belongs.
     * @ORM\ManyToOne(targetEntity="Season")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfSeason;
    /**
     * @type Series $partOfSeries The series to which this episode or season belongs.
     * @ORM\ManyToOne(targetEntity="Series")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfSeries;
    /**
     * @type TVSeries $partOfTVSeries The TV series to which this episode or season belongs. (legacy form; partOfSeries is preferred)
     * @ORM\ManyToOne(targetEntity="TVSeries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $partOfTVSeries;
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
     * @type VideoObject $trailer The trailer of a movie or tv/radio series, season, or episode.
     * @ORM\ManyToOne(targetEntity="VideoObject")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trailer;
}
