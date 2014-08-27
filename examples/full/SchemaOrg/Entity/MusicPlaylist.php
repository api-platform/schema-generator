<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A collection of music tracks in playlist form.
 * 
 * @see http://schema.org/MusicPlaylist Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MusicPlaylist extends CreativeWork
{
    /**
     * @type integer $numTracks The number of tracks in this album or playlist.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $numTracks;
    /**
     * @type MusicRecording $track A music recording (track)&#x2014;usually a single song.
     * @ORM\ManyToOne(targetEntity="MusicRecording")
     */
    private $track;
}
