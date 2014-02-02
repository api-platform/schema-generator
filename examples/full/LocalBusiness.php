<?php

namespace SchemaOrg;

/**
 * Local Business
 *
 * @link http://schema.org/LocalBusiness
 */
class LocalBusiness extends Organization
{
    /**
     * Branch of
     *
     * @var Organization The larger organization that this local business is a branch of, if any.
     */
    protected $branchOf;
    /**
     * Currencies Accepted
     *
     * @var string The currency accepted (in <a href="http://en.wikipedia.org/wiki/ISO_4217">ISO 4217 currency format</a>).
     */
    protected $currenciesAccepted;
    /**
     * Opening Hours
     *
     * @var Duration The opening hours for a business. Opening hours can be specified as a weekly time range, starting with days, then times per day. Multiple days can be listed with commas ',' separating each day. Day or time ranges are specified using a hyphen '-'.<br/>- Days are specified using the following two-letter combinations: <code>Mo</code>, <code>Tu</code>, <code>We</code>, <code>Th</code>, <code>Fr</code>, <code>Sa</code>, <code>Su</code>.<br/>- Times are specified using 24:00 time. For example, 3pm is specified as <code>15:00</code>. <br/>- Here is an example: <code>&lt;time itemprop="openingHours" datetime="Tu,Th 16:00-20:00"&gt;Tuesdays and Thursdays 4-8pm&lt;/time&gt;</code>. <br/>- If a business is open 7 days a week, then it can be specified as <code>&lt;time itemprop="openingHours" datetime="Mo-Su"&gt;Monday through Sunday, all day&lt;/time&gt;</code>.
     */
    protected $openingHours;
    /**
     * Payment Accepted
     *
     * @var string Cash, credit card, etc.
     */
    protected $paymentAccepted;
    /**
     * Price Range
     *
     * @var string The price range of the business, for example <code>$$$</code>.
     */
    protected $priceRange;
}
