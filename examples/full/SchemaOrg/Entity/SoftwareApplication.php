<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A software application.
 * 
 * @see http://schema.org/SoftwareApplication Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class SoftwareApplication extends CreativeWork
{
    /**
     * @type string $applicationCategory Type of software application, e.g. "Game, Multimedia".
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $applicationCategory;
    /**
     * @type string $applicationSubCategory Subcategory of the application, e.g. "Arcade Game".
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $applicationSubCategory;
    /**
     * @type string $applicationSuite The name of the application suite to which the application belongs (e.g. Excel belongs to Office)
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $applicationSuite;
    /**
     * @type string $countriesNotSupported Countries for which the application is not supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $countriesNotSupported;
    /**
     * @type string $countriesSupported Countries for which the application is supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $countriesSupported;
    /**
     * @type string $device Device required to run the application. Used in cases where a specific make/model is required to run the application.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $device;
    /**
     * @type string $downloadUrl If the file can be downloaded, URL to download the binary.
     * @Assert\Url
     * @ORM\Column
     */
    private $downloadUrl;
    /**
     * @type string $featureList Features or modules provided by this application (and possibly required by other applications).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $featureList;
    /**
     * @type string $fileFormat MIME format of the binary (e.g. application/zip).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $fileFormat;
    /**
     * @type integer $fileSize Size of the application / package (e.g. 18MB). In the absence of a unit (MB, KB etc.), KB will be assumed.
     * @Assert\Type(type="integer")
     * @ORM\Column(type="integer")
     */
    private $fileSize;
    /**
     * @type string $installUrl URL at which the app may be installed, if different from the URL of the item.
     * @Assert\Url
     * @ORM\Column
     */
    private $installUrl;
    /**
     * @type string $memoryRequirements Minimum memory requirements.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $memoryRequirements;
    /**
     * @type string $operatingSystem Operating systems supported (Windows 7, OSX 10.6, Android 1.6).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $operatingSystem;
    /**
     * @type string $permissions Permission(s) required to run the app (for example, a mobile app may require full internet access or may run only on wifi).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $permissions;
    /**
     * @type string $processorRequirements Processor architecture required to run the application (e.g. IA64).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $processorRequirements;
    /**
     * @type string $releaseNotes Description of what changed in this version.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $releaseNotes;
    /**
     * @type string $requirements Component dependency requirements for application. This includes runtime environments and shared libraries that are not included in the application distribution package, but required to run the application (Examples: DirectX, Java or .NET runtime).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $requirements;
    /**
     * @type ImageObject $screenshot A link to a screenshot image of the app.
     * @ORM\ManyToOne(targetEntity="ImageObject")
     */
    private $screenshot;
    /**
     * @type string $softwareVersion Version of the software instance.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $softwareVersion;
    /**
     * @type string $storageRequirements Storage requirements (free space required).
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $storageRequirements;
}
