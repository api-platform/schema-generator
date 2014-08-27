<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A music recording (track), usually a single song.
 * 
 * @see http://schema.org/MusicRecording Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MusicRecording extends CreativeWork
{
    /**
     * @type MusicGroup $byArtist The artist that performed this album or recording.
     * @ORM\ManyToOne(targetEntity="MusicGroup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $byArtist;
    /**
     * @type Duration $duration The duration of the item (movie, audio recording, event, etc.) in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 date format</a>.
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $duration;
    /**
     * @type MusicAlbum $inAlbum The album to which this recording belongs.
     * @ORM\ManyToOne(targetEntity="MusicAlbum")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inAlbum;
    /**
     * @type MusicPlaylist $inPlaylist The playlist to which this recording belongs.
     * @ORM\ManyToOne(targetEntity="MusicPlaylist")
     * @ORM\JoinColumn(nullable=false)
     */
    private $inPlaylist;
}
