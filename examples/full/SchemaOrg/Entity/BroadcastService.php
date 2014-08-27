<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A delivery service through which content is provided via broadcast over the air or online.
 * 
 * @see http://schema.org/BroadcastService Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class BroadcastService extends Thing
{
    /**
     * @type Place $area The area within which users can expect to reach the broadcast service.
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $area;
    /**
     * @type Organization $broadcaster The organization owning or operating the broadcast service.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $broadcaster;
    /**
     * @type BroadcastService $parentService A broadcast service to which the broadcast service may belong to such as regional variations of a national channel.
     * @ORM\ManyToOne(targetEntity="BroadcastService")
     */
    private $parentService;
}
