<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Audio Object
 * 
 * @link http://schema.org/AudioObject
 * 
 * @ORM\Entity
 */
class AudioObject extends MediaObject
{
    /**
     * Transcript
     * 
     * @var string $transcript If this MediaObject is an AudioObject or VideoObject, the transcript of that object.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $transcript;
}
