<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Leave Action
 * 
 * @link http://schema.org/LeaveAction
 * 
 * @ORM\Entity
 */
class LeaveAction extends InteractAction
{
    /**
     * Event
     * 
     * @var Event $event Upcoming or past event associated with this place or organization.
     * 
     */
    private $event;
}
