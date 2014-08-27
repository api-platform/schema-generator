<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An event happening at a certain time and location, such as a concert, lecture, or festival. Ticketing information may be added via the 'offers' property. Repeated events may be structured as separate Event objects.
 * 
 * @see http://schema.org/Event Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Event extends Thing
{
    /**
     * @type Person $organizer An organizer of an Event.
     * @ORM\ManyToOne(targetEntity="Person")
     */
    private $organizer;
    /**
     * @type Organization $attendee A person or organization attending the event.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $attendee;
    /**
     * @type \DateTime $doorTime The time admission will commence.
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $doorTime;
    /**
     * @type Duration $duration The duration of the item (movie, audio recording, event, etc.) in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 date format</a>.
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $duration;
    /**
     * @type \DateTime $endDate The end date and time of the role, event or item (in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 date format</a>).
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $endDate;
    /**
     * @type EventStatusType $eventStatus An eventStatus of an event represents its status; particularly useful when an event is cancelled or rescheduled.
     * @ORM\ManyToOne(targetEntity="EventStatusType")
     */
    private $eventStatus;
    /**
     * @type Place $location The location of the event, organization or action.
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;
    /**
     * @type Offer $offers An offer to provide this item&#x2014;for example, an offer to sell a product, rent the DVD of a movie, or give away tickets to an event.
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $offers;
    /**
     * @type Organization $performer A performer at the event&#x2014;for example, a presenter, musician, musical group or actor.
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $performer;
    /**
     * @type \DateTime $previousStartDate Used in conjunction with eventStatus for rescheduled or cancelled events. This property contains the previously scheduled start date. For rescheduled events, the startDate property should be used for the newly scheduled start date. In the (rare) case of an event that has been postponed and rescheduled multiple times, this field may be repeated.
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $previousStartDate;
    /**
     * @type \DateTime $startDate The start date and time of the event, role or item (in <a href='http://en.wikipedia.org/wiki/ISO_8601'>ISO 8601 date format</a>).
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $startDate;
    /**
     * @type Event $subEvent An Event that is part of this event. For example, a conference event includes many presentations, each of which is a subEvent of the conference.
     * @ORM\ManyToOne(targetEntity="Event")
     */
    private $subEvent;
    /**
     * @type Event $superEvent An event that this event is a part of. For example, a collection of individual music performances might each have a music festival as their superEvent.
     * @ORM\ManyToOne(targetEntity="Event")
     */
    private $superEvent;
    /**
     * @type string $typicalAgeRange The typical expected age range, e.g. '7-9', '11-'.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $typicalAgeRange;
    /**
     * @type CreativeWork $workPerformed A work performed in some event, for example a play performed in a TheaterEvent.
     * @ORM\ManyToOne(targetEntity="CreativeWork")
     */
    private $workPerformed;
}
