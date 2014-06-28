<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Software Application
 * 
 * @link http://schema.org/SoftwareApplication
 * 
 * @ORM\MappedSuperclass
 */
class SoftwareApplication extends CreativeWork
{
    /**
     * Application Category
     * 
     * @var string $applicationCategory Type of software application, e.g. "Game, Multimedia".
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $applicationCategory;
    /**
     * Application Sub Category
     * 
     * @var string $applicationSubCategory Subcategory of the application, e.g. "Arcade Game".
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $applicationSubCategory;
    /**
     * Application Suite
     * 
     * @var string $applicationSuite The name of the application suite to which the application belongs (e.g. Excel belongs to Office)
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $applicationSuite;
    /**
     * Countries Not Supported
     * 
     * @var string $countriesNotSupported Countries for which the application is not supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $countriesNotSupported;
    /**
     * Countries Supported
     * 
     * @var string $countriesSupported Countries for which the application is supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $countriesSupported;
    /**
     * Device
     * 
     * @var string $device Device required to run the application. Used in cases where a specific make/model is required to run the application.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $device;
    /**
     * Download Url
     * 
     * @var string $downloadUrl If the file can be downloaded, URL to download the binary.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $downloadUrl;
    /**
     * Feature List
     * 
     * @var string $featureList Features or modules provided by this application (and possibly required by other applications).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $featureList;
    /**
     * File Format
     * 
     * @var string $fileFormat MIME format of the binary (e.g. application/zip).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $fileFormat;
    /**
     * File Size
     * 
     * @var integer $fileSize Size of the application / package (e.g. 18MB). In the absence of a unit (MB, KB etc.), KB will be assumed.
     * 
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $fileSize;
    /**
     * Install Url
     * 
     * @var string $installUrl URL at which the app may be installed, if different from the URL of the item.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $installUrl;
    /**
     * Memory Requirements
     * 
     * @var string $memoryRequirements Minimum memory requirements.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $memoryRequirements;
    /**
     * Operating System
     * 
     * @var string $operatingSystem Operating systems supported (Windows 7, OSX 10.6, Android 1.6).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $operatingSystem;
    /**
     * Permissions
     * 
     * @var string $permissions Permission(s) required to run the app (for example, a mobile app may require full internet access or may run only on wifi).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $permissions;
    /**
     * Processor Requirements
     * 
     * @var string $processorRequirements Processor architecture required to run the application (e.g. IA64).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $processorRequirements;
    /**
     * Release Notes
     * 
     * @var string $releaseNotes Description of what changed in this version.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $releaseNotes;
    /**
     * Requirements
     * 
     * @var string $requirements Component dependency requirements for application. This includes runtime environments and shared libraries that are not included in the application distribution package, but required to run the application (Examples: DirectX, Java or .NET runtime).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $requirements;
    /**
     * Screenshot
     * 
     * @var ImageObject $screenshot A link to a screenshot image of the app.
     * 
     * @ORM\ManyToOne(targetEntity="ImageObject")
     */
    private $screenshot;
    /**
     * Software Version
     * 
     * @var string $softwareVersion Version of the software instance.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $softwareVersion;
    /**
     * Storage Requirements
     * 
     * @var string $storageRequirements Storage requirements (free space required).
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $storageRequirements;
}
