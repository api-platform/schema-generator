<?php

namespace SchemaOrg;

/**
 * Receive Action
 *
 * @link http://schema.org/ReceiveAction
 */
class ReceiveAction extends TransferAction
{
    /**
     * Delivery Method
     *
     * @var DeliveryMethod A sub property of instrument. The method of delivery
     */
    protected $deliveryMethod;
    /**
     * Sender (Audience)
     *
     * @var Audience A sub property of participant. The participant who is at the sending end of the action.
     */
    protected $senderAudience;
    /**
     * Sender (Organization)
     *
     * @var Organization A sub property of participant. The participant who is at the sending end of the action.
     */
    protected $senderOrganization;
    /**
     * Sender (Person)
     *
     * @var Person A sub property of participant. The participant who is at the sending end of the action.
     */
    protected $senderPerson;
}
