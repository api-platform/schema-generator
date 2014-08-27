<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of un-registering from a service.<p>Related actions:</p><ul><li><a href="http://schema.org/RegisterAction">RegisterAction</a>: Antagonym of UnRegisterAction.</li><li><a href="http://schema.org/Leave">Leave</a>: Unlike LeaveAction, UnRegisterAction implies that you are unregistering from a service you werer previously registered, rather than leaving a team/group of people.</li></ul>
 * 
 * @see http://schema.org/UnRegisterAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class UnRegisterAction extends InteractAction
{
}
