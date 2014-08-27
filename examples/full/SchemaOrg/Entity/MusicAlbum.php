<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A collection of music tracks.
 * 
 * @see http://schema.org/MusicAlbum Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MusicAlbum extends MusicPlaylist
{
    /**
     * @type MusicGroup $byArtist The artist that performed this album or recording.
     * @ORM\ManyToOne(targetEntity="MusicGroup")
     * @ORM\JoinColumn(nullable=false)
     */
    private $byArtist;
}
