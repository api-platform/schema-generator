<?php

namespace SchemaOrg;

/**
 * Music Group
 *
 * @link http://schema.org/MusicGroup
 */
class MusicGroup extends PerformingGroup
{
    /**
     * Album
     *
     * @var MusicAlbum A music album.
     */
    protected $album;
    /**
     * Music Group Member
     *
     * @var Person A member of the music group—for example, John, Paul, George, or Ringo.
     */
    protected $musicGroupMember;
    /**
     * Track
     *
     * @var MusicRecording A music recording (track)—usually a single song.
     */
    protected $track;
}
