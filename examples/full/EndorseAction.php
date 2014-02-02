<?php

namespace SchemaOrg;

/**
 * Endorse Action
 *
 * @link http://schema.org/EndorseAction
 */
class EndorseAction extends ReactAction
{
    /**
     * Endorsee (Organization)
     *
     * @var Organization A sub property of participant. The person/organization being supported.
     */
    protected $endorseeOrganization;
    /**
     * Endorsee (Person)
     *
     * @var Person A sub property of participant. The person/organization being supported.
     */
    protected $endorseePerson;
}
