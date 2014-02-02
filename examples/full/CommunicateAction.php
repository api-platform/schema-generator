<?php

namespace SchemaOrg;

/**
 * Communicate Action
 *
 * @link http://schema.org/CommunicateAction
 */
class CommunicateAction extends InteractAction
{
    /**
     * About
     *
     * @var Thing The subject matter of the content.
     */
    protected $about;
    /**
     * Language
     *
     * @var Language A sub property of instrument. The languaged used on this action.
     */
    protected $language;
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
