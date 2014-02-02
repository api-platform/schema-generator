<?php

namespace SchemaOrg;

/**
 * Action
 *
 * @link http://schema.org/Action
 */
class Action extends Thing
{
    /**
     * Agent (Organization)
     *
     * @var Organization The direct performer or driver of the action (animate or inanimate). e.g. *John* wrote a book.
     */
    protected $agentOrganization;
    /**
     * Agent (Person)
     *
     * @var Person The direct performer or driver of the action (animate or inanimate). e.g. *John* wrote a book.
     */
    protected $agentPerson;
    /**
     * End Time
     *
     * @var \DateTime When the Action was performed: end time. This is for actions that span a period of time. e.g. John wrote a book from January to *December*.
     */
    protected $endTime;
    /**
     * Instrument
     *
     * @var Thing The object that helped the agent perform the action. e.g. John wrote a book with *a pen*.
     */
    protected $instrument;
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
     * Object
     *
     * @var Thing The object upon the action is carried out, whose state is kept intact or changed. Also known as the semantic roles patient, affected or undergoer (which change their state) or theme (which doesn't). e.g. John read *a book*.
     */
    protected $object;
    /**
     * Participant (Organization)
     *
     * @var Organization Other co-agents that participated in the action indirectly. e.g. John wrote a book with *Steve*.
     */
    protected $participantOrganization;
    /**
     * Participant (Person)
     *
     * @var Person Other co-agents that participated in the action indirectly. e.g. John wrote a book with *Steve*.
     */
    protected $participantPerson;
    /**
     * Result
     *
     * @var Thing The result produced in the action. e.g. John wrote *a book*.
     */
    protected $result;
    /**
     * Start Time
     *
     * @var \DateTime When the Action was performed: start time. This is for actions that span a period of time. e.g. John wrote a book from *January* to December.
     */
    protected $startTime;
}
