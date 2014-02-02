<?php

namespace SchemaOrg;

/**
 * Rent Action
 *
 * @link http://schema.org/RentAction
 */
class RentAction extends TradeAction
{
    /**
     * Landlord (Organization)
     *
     * @var Organization A sub property of participant. The owner of the real estate property. Sub property of destination or participant?
     */
    protected $landlordOrganization;
    /**
     * Landlord (Person)
     *
     * @var Person A sub property of participant. The owner of the real estate property. Sub property of destination or participant?
     */
    protected $landlordPerson;
    /**
     * Real Estate Agent
     *
     * @var RealEstateAgent A sub property of participant. The real estate agent involved in the action.
     */
    protected $realEstateAgent;
}
