<?php

namespace SchemaOrg;

/**
 * Music Album
 *
 * @link http://schema.org/MusicAlbum
 */
class MusicAlbum extends MusicPlaylist
{
    /**
     * By Artist
     *
     * @var MusicGroup The artist that performed this album or recording.
     */
    protected $byArtist;
}
