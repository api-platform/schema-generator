<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of registering to be a user of a service, product or web page.<p>Related actions:</p><ul><li><a href="http://schema.org/JoinAction">JoinAction</a>: Unlike JoinAction, RegisterAction implies you are registering to be a user of a service, *not* a group/team of people.</li><li><a href="http://schema.org/FollowAction">FollowAction</a>: Unlike FollowAction, RegisterAction doesn't imply that the agent is expecting to poll for updates from the object.</li><li><a href="http://schema.org/SubscribeAction">SubscribeAction</a>: Unlike SubscribeAction, RegisterAction doesn't imply that the agent is expecting updates from the object.</li></ul>
 * 
 * @see http://schema.org/RegisterAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class RegisterAction extends InteractAction
{
}
