<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A movie.
 * 
 * @see http://schema.org/Movie Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Movie extends CreativeWork
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
     * @type Duration $duration The duration of the item (movie, audio recording, event, etc.) in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 date format</a>.
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $duration;
    /**
     * @type MusicGroup $musicBy The composer of the movie or TV/radio soundtrack.
     * @ORM\ManyToOne(targetEntity="MusicGroup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $musicBy;
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
