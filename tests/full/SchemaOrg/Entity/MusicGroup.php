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
     */
    private $album;
    /**
     */
    private $musicGroupMember;
    /**
     */
    private $track;
}
