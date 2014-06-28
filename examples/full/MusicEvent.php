<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Music Event
 * 
 * @link http://schema.org/MusicEvent
 * 
 * @ORM\Entity
 */
class MusicEvent extends Event
{
}
