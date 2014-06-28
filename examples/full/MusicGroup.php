<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Music Group
 * 
 * @link http://schema.org/MusicGroup
 * 
 * @ORM\Entity
 */
class MusicGroup extends PerformingGroup
{
    /**
     * Album
     * 
     * @var MusicAlbum $album A music album.
     * 
     * @ORM\ManyToOne(targetEntity="MusicAlbum")
     */
    private $album;
    /**
     * Music Group Member
     * 
     * @var Person $musicGroupMember A member of the music group—for example, John, Paul, George, or Ringo.
     * 
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $musicGroupMember;
    /**
     * Track
     * 
     * @var MusicRecording $track A music recording (track)—usually a single song.
     * 
     * @ORM\ManyToOne(targetEntity="MusicRecording")
     */
    private $track;
}
