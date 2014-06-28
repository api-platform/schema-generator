<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Publication Event
 * 
 * @link http://schema.org/PublicationEvent
 * 
 * @ORM\MappedSuperclass
 */
class PublicationEvent extends Event
{
    /**
     * Free
     * 
     * @var boolean $free A flag to signal that the publication is accessible for free.
     * 
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $free;
    /**
     * Published On
     * 
     * @var BroadcastService $publishedOn A broadcast service associated with the publication event
     * 
     * @ORM\ManyToOne(targetEntity="BroadcastService")
     */
    private $publishedOn;
}
