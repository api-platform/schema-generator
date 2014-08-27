<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of playing/exercising/training/performing for enjoyment, leisure, recreation, Competition or exercise.<p>Related actions:</p><ul><li><a href="http://schema.org/ListenAction">ListenAction</a>: Unlike ListenAction (which is under ConsumeAction), PlayAction refers to performing for an audience or at an event, rather than consuming music.</li><li><a href="http://schema.org/WatchAction">WatchAction</a>: Unlike WatchAction (which is under ConsumeAction), PlayAction refers to showing/displaying for an audience or at an event, rather than consuming visual content.</li></ul>
 * 
 * @see http://schema.org/PlayAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PlayAction extends Action
{
    /**
     * @type Audience $audience The intended audience of the item, i.e. the group for whom the item was created.
     * @ORM\ManyToOne(targetEntity="Audience")
     * @ORM\JoinColumn(nullable=false)
     */
    private $audience;
    /**
     * @type Event $event Upcoming or past event associated with this place or organization.
     */
    private $event;
}
