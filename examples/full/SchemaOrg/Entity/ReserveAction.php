<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reserving a concrete object.<p>Related actions:</p><ul><li><a href="http://schema.org/ScheduleAction">ScheduleAction</a>: Unlike ScheduleAction, ReserveAction reserves concrete objects (e.g. a table, a hotel) towards a time slot / spatial allocation.</li></ul>
 * 
 * @see http://schema.org/ReserveAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ReserveAction extends PlanAction
{
    /**
     * @type \DateTime $scheduledTime The time the object is scheduled to.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $scheduledTime;
}
