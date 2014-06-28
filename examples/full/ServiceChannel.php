<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Service Channel
 * 
 * @link http://schema.org/ServiceChannel
 * 
 * @ORM\Entity
 */
class ServiceChannel extends Intangible
{
    /**
     * Available Language
     * 
     * @var Language $availableLanguage A language someone may use with the item.
     * 
     * @ORM\ManyToOne(targetEntity="Language")
     */
    private $availableLanguage;
    /**
     * Processing Time
     * 
     * @var Duration $processingTime Estimated processing time for the service using this channel.
     * 
     */
    private $processingTime;
    /**
     * Provides Service
     * 
     * @var Service $providesService The service provided by this channel.
     * 
     * @ORM\ManyToOne(targetEntity="Service")
     * @ORM\JoinColumn(nullable=false)
     */
    private $providesService;
    /**
     * Service Location
     * 
     * @var Place $serviceLocation The location (e.g. civic structure, local business, etc.) where a person can go to access the service.
     * 
     * @ORM\ManyToOne(targetEntity="Place")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceLocation;
    /**
     * Service Phone
     * 
     * @var ContactPoint $servicePhone The phone number to use to access the service.
     * 
     * @ORM\ManyToOne(targetEntity="ContactPoint")
     * @ORM\JoinColumn(nullable=false)
     */
    private $servicePhone;
    /**
     * Service Postal Address
     * 
     * @var PostalAddress $servicePostalAddress The address for accessing the service by mail.
     * 
     * @ORM\ManyToOne(targetEntity="PostalAddress")
     * @ORM\JoinColumn(nullable=false)
     */
    private $servicePostalAddress;
    /**
     * Service Sms Number
     * 
     * @var ContactPoint $serviceSmsNumber The number to access the service by text message.
     * 
     * @ORM\ManyToOne(targetEntity="ContactPoint")
     * @ORM\JoinColumn(nullable=false)
     */
    private $serviceSmsNumber;
    /**
     * Service Url
     * 
     * @var string $serviceUrl The website to access the service.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $serviceUrl;
}
