<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Music Playlist
 * 
 * @link http://schema.org/MusicPlaylist
 * 
 * @ORM\MappedSuperclass
 */
class MusicPlaylist extends CreativeWork
{
    /**
     * Num Tracks
     * 
     * @var integer $numTracks The number of tracks in this album or playlist.
     * 
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $numTracks;
    /**
     * Track
     * 
     * @var MusicRecording $track A music recording (track)—usually a single song.
     * 
     * @ORM\ManyToOne(targetEntity="MusicRecording")
     */
    private $track;
}
