<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Invite Action
 * 
 * @link http://schema.org/InviteAction
 * 
 * @ORM\Entity
 */
class InviteAction extends CommunicateAction
{
    /**
     * Event
     * 
     * @var Event $event Upcoming or past event associated with this place or organization.
     * 
     */
    private $event;
}
