<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Video Object
 * 
 * @link http://schema.org/VideoObject
 * 
 * @ORM\Entity
 */
class VideoObject extends MediaObject
{
    /**
     * Caption
     * 
     * @var string $caption The caption for this object.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $caption;
    /**
     * Thumbnail
     * 
     * @var ImageObject $thumbnail Thumbnail image for an image or video.
     * 
     */
    private $thumbnail;
    /**
     * Transcript
     * 
     * @var string $transcript If this MediaObject is an AudioObject or VideoObject, the transcript of that object.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $transcript;
    /**
     * Video Frame Size
     * 
     * @var string $videoFrameSize The frame size of the video.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $videoFrameSize;
    /**
     * Video Quality
     * 
     * @var string $videoQuality The quality of the video.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $videoQuality;
}
