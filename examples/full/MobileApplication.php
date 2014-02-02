<?php

namespace SchemaOrg;

/**
 * Mobile Application
 *
 * @link http://schema.org/MobileApplication
 */
class MobileApplication extends SoftwareApplication
{
    /**
     * Carrier Requirements
     *
     * @var string Specifies specific carrier(s) requirements for the application (e.g. an application may only work on a specific carrier network).
     */
    protected $carrierRequirements;
}
