<?php

namespace SchemaOrg;

/**
 * Return Action
 *
 * @link http://schema.org/ReturnAction
 */
class ReturnAction extends TransferAction
{
    /**
     * Recipient (Organization)
     *
     * @var Organization A sub property of participant. The participant who is at the receiving end of the action.
     */
    protected $recipientOrganization;
    /**
     * Recipient (Audience)
     *
     * @var Audience A sub property of participant. The participant who is at the receiving end of the action.
     */
    protected $recipientAudience;
    /**
     * Recipient (Person)
     *
     * @var Person A sub property of participant. The participant who is at the receiving end of the action.
     */
    protected $recipientPerson;
}
