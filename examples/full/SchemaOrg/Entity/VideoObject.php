<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A video file.
 * 
 * @see http://schema.org/VideoObject Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class VideoObject extends MediaObject
{
    /**
     * @type string $caption The caption for this object.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $caption;
    /**
     * @type Organization $productionCompany The production company or studio that made the movie, tv/radio series, season, or episode, or media object.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $productionCompany;
    /**
     * @type ImageObject $thumbnail Thumbnail image for an image or video.
     */
    private $thumbnail;
    /**
     * @type string $transcript If this MediaObject is an AudioObject or VideoObject, the transcript of that object.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $transcript;
    /**
     * @type string $videoFrameSize The frame size of the video.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $videoFrameSize;
    /**
     * @type string $videoQuality The quality of the video.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $videoQuality;
}
