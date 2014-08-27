<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of asking someone to attend an event. Reciprocal of RsvpAction.
 * 
 * @see http://schema.org/InviteAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class InviteAction extends CommunicateAction
{
    /**
     * @type Event $event Upcoming or past event associated with this place or organization.
     */
    private $event;
}
