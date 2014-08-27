<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A means for accessing a service, e.g. a government office location, web site, or phone number.
 * 
 * @see http://schema.org/ServiceChannel Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ServiceChannel extends Intangible
{
    /**
     * @type Language $availableLanguage A language someone may use with the item.
     * @ORM\ManyToOne(targetEntity="Language")
     */
    private $availableLanguage;
    /**
     * @type Duration $processingTime Estimated processing time for the service using this channel.
     */
    private $processingTime;
    /**
     * @type Service $providesService The service provided by this channel.
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(nullable=false)
     */
    private $providesService;
    /**
     * @type Place $serviceLocation The location (e.g. civic structure, local business, etc.) where a person can go to access the service.
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceLocation;
    /**
     * @type ContactPoint $servicePhone The phone number to use to access the service.
     * @ORM\ManyToOne(targetEntity="ContactPoint")
     * @ORM\JoinColumn(nullable=false)
     */
    private $servicePhone;
    /**
     * @type PostalAddress $servicePostalAddress The address for accessing the service by mail.
     * @ORM\ManyToOne(targetEntity="PostalAddress")
     * @ORM\JoinColumn(nullable=false)
     */
    private $servicePostalAddress;
    /**
     * @type ContactPoint $serviceSmsNumber The number to access the service by text message.
     * @ORM\ManyToOne(targetEntity="ContactPoint")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceSmsNumber;
    /**
     * @type string $serviceUrl The website to access the service.
     * @Assert\Url
     * @ORM\Column
     */
    private $serviceUrl;
}
