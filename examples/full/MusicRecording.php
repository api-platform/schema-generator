<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Music Recording
 * 
 * @link http://schema.org/MusicRecording
 * 
 * @ORM\Entity
 */
class MusicRecording extends CreativeWork
{
    /**
     * By Artist
     * 
     * @var MusicGroup $byArtist The artist that performed this album or recording.
     * 
     * @ORM\ManyToOne(targetEntity="MusicGroup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $byArtist;
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
     * In Album
     * 
     * @var MusicAlbum $inAlbum The album to which this recording belongs.
     * 
     * @ORM\ManyToOne(targetEntity="MusicAlbum")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inAlbum;
    /**
     * In Playlist
     * 
     * @var MusicPlaylist $inPlaylist The playlist to which this recording belongs.
     * 
     * @ORM\ManyToOne(targetEntity="MusicPlaylist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inPlaylist;
}
