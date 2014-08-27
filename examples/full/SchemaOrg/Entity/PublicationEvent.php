<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A PublicationEvent corresponds indifferently to the event of publication for a CreativeWork of any type e.g. a broadcast event, an on-demand event, a book/journal publication via a variety of delivery media.
 * 
 * @see http://schema.org/PublicationEvent Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PublicationEvent extends Event
{
    /**
     * @type boolean $free A flag to signal that the publication is accessible for free.
     * @Assert\Type(type="boolean")
     * @ORM\Column(type="boolean")
     */
    private $free;
    /**
     * @type BroadcastService $publishedOn A broadcast service associated with the publication event.
     * @ORM\ManyToOne(targetEntity="BroadcastService")
     */
    private $publishedOn;
}
