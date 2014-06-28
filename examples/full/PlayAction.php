<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Play Action
 * 
 * @link http://schema.org/PlayAction
 * 
 * @ORM\MappedSuperclass
 */
class PlayAction extends Action
{
    /**
     * Audience
     * 
     * @var Audience $audience The intended audience of the item, i.e. the group for whom the item was created.
     * 
     * @ORM\ManyToOne(targetEntity="Audience")
     * @ORM\JoinColumn(nullable=false)
     */
    private $audience;
    /**
     * Event
     * 
     * @var Event $event Upcoming or past event associated with this place or organization.
     * 
     */
    private $event;
}
