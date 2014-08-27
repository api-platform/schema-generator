<?php


namespace SchemaOrg\Enum;

use MyCLabs\Enum\Enum;

/**
 * The status of an Action.
 * 
 * @see http://schema.org/ActionStatusType Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ActionStatusType extends Enum
{
    /**
     * @type string POTENTIAL_ACTION_STATUS A description of an action that is supported.
    */
    const POTENTIAL_ACTION_STATUS = 'http://schema.org/PotentialActionStatus';
    /**
     * @type string ACTIVE_ACTION_STATUS An in-progress action (e.g, while watching the movie, or driving to a location).
    */
    const ACTIVE_ACTION_STATUS = 'http://schema.org/ActiveActionStatus';
    /**
     * @type string COMPLETED_ACTION_STATUS An action that has already taken place.
    */
    const COMPLETED_ACTION_STATUS = 'http://schema.org/CompletedActionStatus';
}
