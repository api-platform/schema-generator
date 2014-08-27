<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of forming a personal connection with someone (object) mutually/bidirectionally/symmetrically.<p>Related actions:</p><ul><li><a href="http://schema.org/FollowAction">FollowAction</a>: Unlike FollowAction, BefriendAction implies that the connection is reciprocal.</li></ul>
 * 
 * @see http://schema.org/BefriendAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BefriendAction extends InteractAction
{
}
