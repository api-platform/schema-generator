<?php


namespace SchemaOrg\Enum;


/**
 * Enumerated options related to a ContactPoint
 * 
 * @see http://schema.org/ContactPointOption Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ContactPointOption extends Enum
{
    /**
     * @type string HEARING_IMPAIRED_SUPPORTED Uses devices to support users with hearing impairments.
    */
    const HEARING_IMPAIRED_SUPPORTED = 'http://schema.org/HearingImpairedSupported';
    /**
     * @type string TOLL_FREE The associated telephone number is toll free.
    */
    const TOLL_FREE = 'http://schema.org/TollFree';
}
