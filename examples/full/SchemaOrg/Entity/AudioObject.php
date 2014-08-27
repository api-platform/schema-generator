<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An audio file.
 * 
 * @see http://schema.org/AudioObject Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class AudioObject extends MediaObject
{
    /**
     * @type string $transcript If this MediaObject is an AudioObject or VideoObject, the transcript of that object.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $transcript;
}
