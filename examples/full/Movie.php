<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Movie
 * 
 * @link http://schema.org/Movie
 * 
 * @ORM\Entity
 */
class Movie extends CreativeWork
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
     * Duration
     * 
     * @var Duration $duration The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.
     * 
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $duration;
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
     * Trailer
     * 
     * @var VideoObject $trailer The trailer of a movie or tv/radio series, season, or episode.
     * 
     * @ORM\ManyToOne(targetEntity="VideoObject")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trailer;
}
