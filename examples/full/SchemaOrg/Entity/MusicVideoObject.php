<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A music video file.
 * 
 * @see http://schema.org/MusicVideoObject Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MusicVideoObject extends MediaObject
{
}
