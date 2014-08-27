<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of planning the execution of an event/task/action/reservation/plan to a future date.
 * 
 * @see http://schema.org/PlanAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PlanAction extends OrganizeAction
{
    /**
     * @type \DateTime $scheduledTime The time the object is scheduled to.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $scheduledTime;
}
