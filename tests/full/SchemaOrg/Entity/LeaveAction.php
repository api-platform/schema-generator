<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An agent leaves an event / group with participants/friends at a location.<p>Related actions:</p><ul><li><a href="http://schema.org/JoinAction">JoinAction</a>: The antagonym of LeaveAction.</li><li><a href="http://schema.org/UnRegisterAction">UnRegisterAction</a>: Unlike UnRegisterAction, LeaveAction implies leaving a group/team of people rather than a service.</li></ul>
 * 
 * @see http://schema.org/LeaveAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class LeaveAction extends InteractAction
{
    /**
     */
    private $event;
}
