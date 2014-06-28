<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Plan Action
 * 
 * @link http://schema.org/PlanAction
 * 
 * @ORM\MappedSuperclass
 */
class PlanAction extends OrganizeAction
{
    /**
     * Scheduled Time
     * 
     * @var \DateTime $scheduledTime The time the object is scheduled to.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $scheduledTime;
}
