<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Season dedicated to radio broadcast and associated online delivery.
 * 
 * @see http://schema.org/RadioSeason Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RadioSeason extends Season
{
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
     * @type VideoObject $trailer The trailer of a movie or tv/radio series, season, or episode.
     * @ORM\ManyToOne(targetEntity="VideoObject")
     * @ORM\JoinColumn(nullable=false)
     */
    private $trailer;
}
