<?php


namespace SchemaOrg\Enum;


/**
 * EventStatusType is an enumeration type whose instances represent several states that an Event may be in.
 * 
 * @see http://schema.org/EventStatusType Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class EventStatusType extends Enum
{
    /**
     * @type string EVENT_CANCELLED The event has been cancelled. If the event has multiple startDate values, all are assumed to be cancelled. Either startDate or previousStartDate may be used to specify the event's cancelled date(s).
    */
    const EVENT_CANCELLED = 'http://schema.org/EventCancelled';
    /**
     * @type string EVENT_POSTPONED The event has been postponed and no new date has been set. The event's previousStartDate should be set.
    */
    const EVENT_POSTPONED = 'http://schema.org/EventPostponed';
    /**
     * @type string EVENT_RESCHEDULED The event has been rescheduled. The event's previousStartDate should be set to the old date and the startDate should be set to the event's new date. (If the event has been rescheduled multiple times, the previousStartDate property may be repeated.)
    */
    const EVENT_RESCHEDULED = 'http://schema.org/EventRescheduled';
    /**
     * @type string EVENT_SCHEDULED The event is taking place or has taken place on the startDate as scheduled. Use of this value is optional, as it is assumed by default.
    */
    const EVENT_SCHEDULED = 'http://schema.org/EventScheduled';
}
