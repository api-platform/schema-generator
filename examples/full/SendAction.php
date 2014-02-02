<?php

namespace SchemaOrg;

/**
 * Send Action
 *
 * @link http://schema.org/SendAction
 */
class SendAction extends TransferAction
{
    /**
     * Delivery Method
     *
     * @var DeliveryMethod A sub property of instrument. The method of delivery
     */
    protected $deliveryMethod;
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
