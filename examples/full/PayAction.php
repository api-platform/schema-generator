<?php

namespace SchemaOrg;

/**
 * Pay Action
 *
 * @link http://schema.org/PayAction
 */
class PayAction extends TradeAction
{
    /**
     * Purpose (Thing)
     *
     * @var Thing A goal towards an action is taken. Can be concrete or abstract.
     */
    protected $purposeThing;
    /**
     * Purpose (MedicalDevicePurpose)
     *
     * @var MedicalDevicePurpose A goal towards an action is taken. Can be concrete or abstract.
     */
    protected $purposeMedicalDevicePurpose;
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
