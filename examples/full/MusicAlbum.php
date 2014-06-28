<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Music Album
 * 
 * @link http://schema.org/MusicAlbum
 * 
 * @ORM\Entity
 */
class MusicAlbum extends MusicPlaylist
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
}
