<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An action performed by a direct agent and indirect     participants upon a direct object. Optionally happens at a location     with the help of an inanimate instrument. The execution of the action     may produce a result. Specific action sub-type documentation specifies     the exact expectation of each argument/role.
 * 
 * @see http://schema.org/Action Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Action extends Thing
{
    /**
     * @type Organization $agent The direct performer or driver of the action (animate or inanimate). e.g. *John* wrote a book.
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agent;
    /**
     * @type \DateTime $endTime The endTime of something. For a reserved event or service (e.g. FoodEstablishmentReservation), the time that it is expected to end. For actions that span a period of time, when the action was performed. e.g. John wrote a book from January to *December*.

Note that Event uses startDate/endDate instead of startTime/endTime, even when describing dates with times. This situation may be clarified in future revisions.

     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $endTime;
    /**
     * @type Thing $instrument The object that helped the agent perform the action. e.g. John wrote a book with *a pen*.
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $instrument;
    /**
     * @type Place $location The location of the event, organization or action.
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;
    /**
     * @type Thing $object The object upon the action is carried out, whose state is kept intact or changed. Also known as the semantic roles patient, affected or undergoer (which change their state) or theme (which doesn't). e.g. John read *a book*.
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $object;
    /**
     * @type Organization $participant Other co-agents that participated in the action indirectly. e.g. John wrote a book with *Steve*.
     */
    private $participant;
    /**
     * @type Thing $result The result produced in the action. e.g. John wrote *a book*.
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $result;
    /**
     * @type \DateTime $startTime The startTime of something. For a reserved event or service (e.g. FoodEstablishmentReservation), the time that it is expected to start. For actions that span a period of time, when the action was performed. e.g. John wrote a book from *January* to December.

Note that Event uses startDate/endDate instead of startTime/endTime, even when describing dates with times. This situation may be clarified in future revisions.

     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $startTime;
    /**
     * @type ActionStatusType $actionStatus Indicates the current disposition of the Action.
     */
    private $actionStatus;
    /**
     * @type EntryPoint $target Indicates a target EntryPoint for an Action.
     */
    private $target;
}
