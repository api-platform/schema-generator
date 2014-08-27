<?php


namespace SchemaOrg\Enum;

use MyCLabs\Enum\Enum;

/**
 * Enumerated status values for Reservation.
 * 
 * @see http://schema.org/ReservationStatusType Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ReservationStatusType extends Enum
{
    /**
     * @type string RESERVATION_CANCELLED The status for a previously confirmed reservation that is now cancelled.
    */
    const RESERVATION_CANCELLED = 'http://schema.org/ReservationCancelled';
    /**
     * @type string RESERVATION_CONFIRMED The status of a confirmed reservation.
    */
    const RESERVATION_CONFIRMED = 'http://schema.org/ReservationConfirmed';
    /**
     * @type string RESERVATION_HOLD The status of a reservation on hold pending an update like credit card number or flight changes.
    */
    const RESERVATION_HOLD = 'http://schema.org/ReservationHold';
    /**
     * @type string RESERVATION_PENDING The status of a reservation when a request has been sent, but not confirmed.
    */
    const RESERVATION_PENDING = 'http://schema.org/ReservationPending';
}
