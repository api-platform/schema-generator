<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Scheduling future actions, events, or tasks.<p>Related actions:</p><ul><li><a href="http://schema.org/ReserveAction">ReserveAction</a>: Unlike ReserveAction, ScheduleAction allocates future actions (e.g. an event, a task, etc) towards a time slot / spatial allocation.</li></ul>
 * 
 * @see http://schema.org/ScheduleAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ScheduleAction extends PlanAction
{
}
