<?php

namespace SchemaOrg;

/**
 * Service Channel
 *
 * @link http://schema.org/ServiceChannel
 */
class ServiceChannel extends Intangible
{
    /**
     * Available Language
     *
     * @var Language A language someone may use with the item.
     */
    protected $availableLanguage;
    /**
     * Processing Time
     *
     * @var Duration Estimated processing time for the service using this channel.
     */
    protected $processingTime;
    /**
     * Provides Service
     *
     * @var Service The service provided by this channel.
     */
    protected $providesService;
    /**
     * Service Location
     *
     * @var Place The location (e.g. civic structure, local business, etc.) where a person can go to access the service.
     */
    protected $serviceLocation;
    /**
     * Service Phone
     *
     * @var ContactPoint The phone number to use to access the service.
     */
    protected $servicePhone;
    /**
     * Service Postal Address
     *
     * @var PostalAddress The address for accessing the service by mail.
     */
    protected $servicePostalAddress;
    /**
     * Service Sms Number
     *
     * @var ContactPoint The number to access the service by text message.
     */
    protected $serviceSmsNumber;
    /**
     * Service Url
     *
     * @var string The website to access the service.
     */
    protected $serviceUrl;
}
