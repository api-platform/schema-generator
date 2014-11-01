<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An agent tracks an object for updates.<p>Related actions:</p><ul><li><a href="http://schema.org/FollowAction">FollowAction</a>: Unlike FollowAction, TrackAction refers to the interest on the location of innanimates objects.</li><li><a href="http://schema.org/SubscribeAction">SubscribeAction</a>: Unlike SubscribeAction, TrackAction refers to  the interest on the location of innanimate objects.</li></ul>
 * 
 * @see http://schema.org/TrackAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class TrackAction extends FindAction
{
    /**
     */
    private $deliveryMethod;
}
