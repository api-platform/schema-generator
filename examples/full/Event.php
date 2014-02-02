<?php

namespace SchemaOrg;

/**
 * Event
 *
 * @link http://schema.org/Event
 */
class Event extends Thing
{
    /**
     * Attendee (Organization)
     *
     * @var Organization A person or organization attending the event.
     */
    protected $attendeeOrganization;
    /**
     * Attendee (Person)
     *
     * @var Person A person or organization attending the event.
     */
    protected $attendeePerson;
    /**
     * Door Time
     *
     * @var \DateTime The time admission will commence.
     */
    protected $doorTime;
    /**
     * Duration
     *
     * @var Duration The duration of the item (movie, audio recording, event, etc.) in <a href="http://en.wikipedia.org/wiki/ISO_8601">ISO 8601 date format</a>.
     */
    protected $duration;
    /**
     * End Date
     *
     * @var \DateTime The end date and time of the event or item (in <a href="http://en.wikipedia.org/wiki/ISO_8601">ISO 8601 date format</a>).
     */
    protected $endDate;
    /**
     * Event Status
     *
     * @var EventStatusType An eventStatus of an event represents its status; particularly useful when an event is cancelled or rescheduled.
     */
    protected $eventStatus;
    /**
     * Location (PostalAddress)
     *
     * @var PostalAddress The location of the event, organization or action.
     */
    protected $locationPostalAddress;
    /**
     * Location (Place)
     *
     * @var Place The location of the event, organization or action.
     */
    protected $locationPlace;
    /**
     * Offers
     *
     * @var Offer An offer to sell this item—for example, an offer to sell a product, the DVD of a movie, or tickets to an event.
     */
    protected $offers;
    /**
     * Performer (Organization)
     *
     * @var Organization A performer at the event—for example, a presenter, musician, musical group or actor.
     */
    protected $performerOrganization;
    /**
     * Performer (Person)
     *
     * @var Person A performer at the event—for example, a presenter, musician, musical group or actor.
     */
    protected $performerPerson;
    /**
     * Previous Start Date
     *
     * @var \DateTime Used in conjunction with eventStatus for rescheduled or cancelled events. This property contains the previously scheduled start date. For rescheduled events, the startDate property should be used for the newly scheduled start date. In the (rare) case of an event that has been postponed and rescheduled multiple times, this field may be repeated.
     */
    protected $previousStartDate;
    /**
     * Start Date
     *
     * @var \DateTime The start date and time of the event or item (in <a href="http://en.wikipedia.org/wiki/ISO_8601">ISO 8601 date format</a>).
     */
    protected $startDate;
    /**
     * Sub Event
     *
     * @var Event An Event that is part of this event. For example, a conference event includes many presentations, each are a subEvent of the conference.
     */
    protected $subEvent;
    /**
     * Super Event
     *
     * @var Event An event that this event is a part of. For example, a collection of individual music performances might each have a music festival as their superEvent.
     */
    protected $superEvent;
    /**
     * Typical Age Range
     *
     * @var string The typical expected age range, e.g. '7-9', '11-'.
     */
    protected $typicalAgeRange;
}
