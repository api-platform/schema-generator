<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Episode
 * 
 * @link http://schema.org/Episode
 * 
 * @ORM\MappedSuperclass
 */
class Episode extends CreativeWork
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
     * Episode Number
     * 
     * @var integer $episodeNumber Position of the episode within an ordered group of episodes.
     * 
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $episodeNumber;
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
     * Publication
     * 
     * @var PublicationEvent $publication A publication event associated with the episode, clip or media object.
     * 
     * @ORM\ManyToOne(targetEntity="PublicationEvent")
     */
    private $publication;
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
