<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Broadcast Service
 * 
 * @link http://schema.org/BroadcastService
 * 
 * @ORM\Entity
 */
class BroadcastService extends Thing
{
    /**
     * Area
     * 
     * @var Place $area The area within which users can expect to reach the broadcast service.
     * 
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $area;
    /**
     * Broadcaster
     * 
     * @var Organization $broadcaster The organization owning or operating the broadcast service.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $broadcaster;
    /**
     * Parent Service
     * 
     * @var BroadcastService $parentService A broadcast service to which the broadcast service may belong to such as regional variations of a national channel.
     * 
     * @ORM\ManyToOne(targetEntity="BroadcastService")
     */
    private $parentService;
}
