<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 * 
 * @link http://schema.org/Event
 * 
 * @ORM\MappedSuperclass
 */
class Event extends Thing
{
    /**
     * Attendee
     * 
     * @var Organization $attendee A person or organization attending the event.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $attendee;
    /**
     * Door Time
     * 
     * @var \DateTime $doorTime The time admission will commence.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $doorTime;
    /**
     * Duration
     * 
     * @var Duration $duration The duration of the item (movie, audio recording, event, etc.) in ISO 8601 date format.
     * 
     * @ORM\ManyToOne(targetEntity="Duration")
     * @ORM\JoinColumn(nullable=false)
     */
    private $duration;
    /**
     * End Date
     * 
     * @var \DateTime $endDate The end date and time of the event or item (in ISO 8601 date format).
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $endDate;
    /**
     * Event Status
     * 
     * @var EventStatusType $eventStatus An eventStatus of an event represents its status; particularly useful when an event is cancelled or rescheduled.
     * 
     * @ORM\ManyToOne(targetEntity="EventStatusType")
     */
    private $eventStatus;
    /**
     * Location
     * 
     * @var PostalAddress $location The location of the event, organization or action.
     * 
     * @ORM\ManyToOne(targetEntity="PostalAddress")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;
    /**
     * Offers
     * 
     * @var Offer $offers An offer to transfer some rights to an item or to provide a service—for example, an offer to sell tickets to an event, to rent the DVD of a movie, to stream a TV show over the internet, to repair a motorcycle, or to loan a book.
     * 
     * @ORM\ManyToOne(targetEntity="Offer")
     */
    private $offers;
    /**
     * Performer
     * 
     * @var Organization $performer A performer at the event—for example, a presenter, musician, musical group or actor.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     */
    private $performer;
    /**
     * Previous Start Date
     * 
     * @var \DateTime $previousStartDate Used in conjunction with eventStatus for rescheduled or cancelled events. This property contains the previously scheduled start date. For rescheduled events, the startDate property should be used for the newly scheduled start date. In the (rare) case of an event that has been postponed and rescheduled multiple times, this field may be repeated.
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $previousStartDate;
    /**
     * Start Date
     * 
     * @var \DateTime $startDate The start date and time of the event or item (in ISO 8601 date format).
     * 
     * @Assert\Date
     * @ORM\Column(type="date")
     */
    private $startDate;
    /**
     * Sub Event
     * 
     * @var Event $subEvent An Event that is part of this event. For example, a conference event includes many presentations, each are a subEvent of the conference.
     * 
     * @ORM\ManyToOne(targetEntity="Event")
     */
    private $subEvent;
    /**
     * Super Event
     * 
     * @var Event $superEvent An event that this event is a part of. For example, a collection of individual music performances might each have a music festival as their superEvent.
     * 
     * @ORM\ManyToOne(targetEntity="Event")
     */
    private $superEvent;
    /**
     * Typical Age Range
     * 
     * @var string $typicalAgeRange The typical expected age range, e.g. '7-9', '11-'.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $typicalAgeRange;
}
