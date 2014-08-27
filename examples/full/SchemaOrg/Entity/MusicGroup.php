<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A musical group, such as a band, an orchestra, or a choir. Can also be a solo musician.
 * 
 * @see http://schema.org/MusicGroup Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MusicGroup extends PerformingGroup
{
    /**
     * @type MusicAlbum $album A music album.
     * @ORM\ManyToOne(targetEntity="MusicAlbum")
     */
    private $album;
    /**
     * @type Person $musicGroupMember A member of a music group&#x2014;for example, John, Paul, George, or Ringo.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $musicGroupMember;
    /**
     * @type MusicRecording $track A music recording (track)&#x2014;usually a single song.
     * @ORM\ManyToOne(targetEntity="MusicRecording")
     */
    private $track;
}
