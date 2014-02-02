<?php

namespace SchemaOrg;

/**
 * Opening Hours Specification
 *
 * @link http://schema.org/OpeningHoursSpecification
 */
class OpeningHoursSpecification extends StructuredValue
{
    /**
     * Closes
     *
     * @var \DateTime The closing hour of the place or service on the given day(s) of the week.
     */
    protected $closes;
    /**
     * Day of Week
     *
     * @var DayOfWeek The day of the week for which these opening hours are valid.
     */
    protected $dayOfWeek;
    /**
     * Opens
     *
     * @var \DateTime The opening hour of the place or service on the given day(s) of the week.
     */
    protected $opens;
    /**
     * Valid From
     *
     * @var \DateTime The date when the item becomes valid.
     */
    protected $validFrom;
    /**
     * Valid Through
     *
     * @var \DateTime The end of the validity of offer, price specification, or opening hours data.
     */
    protected $validThrough;
}
