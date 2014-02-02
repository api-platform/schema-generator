<?php

namespace SchemaOrg;

/**
 * Follow Action
 *
 * @link http://schema.org/FollowAction
 */
class FollowAction extends InteractAction
{
    /**
     * Followee (Organization)
     *
     * @var Organization A sub property of object. The person or organization being followed.
     */
    protected $followeeOrganization;
    /**
     * Followee (Person)
     *
     * @var Person A sub property of object. The person or organization being followed.
     */
    protected $followeePerson;
}
