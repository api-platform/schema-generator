<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Action
 * 
 * @link http://schema.org/Action
 * 
 * @ORM\MappedSuperclass
 */
class Action extends Thing
{
    /**
     * Agent
     * 
     * @var Organization $agent The direct performer or driver of the action (animate or inanimate). e.g. *John* wrote a book.
     * 
     * @ORM\ManyToOne(targetEntity="Organization")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agent;
    /**
     * End Time
     * 
     * @var \DateTime $endTime When the Action was performed: end time. This is for actions that span a period of time. e.g. John wrote a book from January to *December*.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $endTime;
    /**
     * Instrument
     * 
     * @var Thing $instrument The object that helped the agent perform the action. e.g. John wrote a book with *a pen*.
     * 
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $instrument;
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
     * Object
     * 
     * @var Thing $object The object upon the action is carried out, whose state is kept intact or changed. Also known as the semantic roles patient, affected or undergoer (which change their state) or theme (which doesn't). e.g. John read *a book*.
     * 
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $object;
    /**
     * Participant
     * 
     * @var Organization $participant Other co-agents that participated in the action indirectly. e.g. John wrote a book with *Steve*.
     * 
     */
    private $participant;
    /**
     * Result
     * 
     * @var Thing $result The result produced in the action. e.g. John wrote *a book*.
     * 
     * @ORM\ManyToOne(targetEntity="Thing")
     * @ORM\JoinColumn(nullable=false)
     */
    private $result;
    /**
     * Start Time
     * 
     * @var \DateTime $startTime When the Action was performed: start time. This is for actions that span a period of time. e.g. John wrote a book from *January* to December.
     * 
     * @Assert\DateTime
     * @ORM\Column(type="datetime")
     */
    private $startTime;
}
