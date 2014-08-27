<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A TV or radio episode which can be part of a series or season.
 * 
 * @see http://schema.org/Episode Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Episode extends CreativeWork
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
     * @type integer $episodeNumber Position of the episode within an ordered group of episodes.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $episodeNumber;
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
     * @type PublicationEvent $publication A publication event associated with the episode, clip or media object.
     * @ORM\ManyToOne(targetEntity="PublicationEvent")
     */
    private $publication;
    /**
     * @type VideoObject $trailer The trailer of a movie or tv/radio series, season, or episode.
     * @ORM\ManyToOne(targetEntity="VideoObject")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trailer;
}
