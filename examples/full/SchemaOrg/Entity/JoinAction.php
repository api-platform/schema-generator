<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An agent joins an event/group with participants/friends at a location.<p>Related actions:</p><ul><li><a href="http://schema.org/RegisterAction">RegisterAction</a>: Unlike RegisterAction, JoinAction refers to joining a group/team of people.</li><li><a href="http://schema.org/SubscribeAction">SubscribeAction</a>: Unlike SubscribeAction, JoinAction does not imply that you'll be receiving updates.</li><li><a href="http://schema.org/FollowAction">FollowAction</a>: Unlike FollowAction, JoinAction does not imply that you'll be polling for updates.</li></ul>
 * 
 * @see http://schema.org/JoinAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class JoinAction extends InteractAction
{
    /**
     * @type Event $event Upcoming or past event associated with this place or organization.
     */
    private $event;
}
