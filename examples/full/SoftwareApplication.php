<?php

namespace SchemaOrg;

/**
 * Software Application
 *
 * @link http://schema.org/SoftwareApplication
 */
class SoftwareApplication extends CreativeWork
{
    /**
     * Application Category (Text)
     *
     * @var string Type of software application, e.g. "Game, Multimedia".
     */
    protected $applicationCategoryText;
    /**
     * Application Category (URL)
     *
     * @var string Type of software application, e.g. "Game, Multimedia".
     */
    protected $applicationCategoryURL;
    /**
     * Application Sub Category (Text)
     *
     * @var string Subcategory of the application, e.g. "Arcade Game".
     */
    protected $applicationSubCategoryText;
    /**
     * Application Sub Category (URL)
     *
     * @var string Subcategory of the application, e.g. "Arcade Game".
     */
    protected $applicationSubCategoryURL;
    /**
     * Application Suite
     *
     * @var string The name of the application suite to which the application belongs (e.g. Excel belongs to Office)
     */
    protected $applicationSuite;
    /**
     * Countries Not Supported
     *
     * @var string Countries for which the application is not supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     */
    protected $countriesNotSupported;
    /**
     * Countries Supported
     *
     * @var string Countries for which the application is supported. You can also provide the two-letter ISO 3166-1 alpha-2 country code.
     */
    protected $countriesSupported;
    /**
     * Device
     *
     * @var string Device required to run the application. Used in cases where a specific make/model is required to run the application.
     */
    protected $device;
    /**
     * Download Url
     *
     * @var string If the file can be downloaded, URL to download the binary.
     */
    protected $downloadUrl;
    /**
     * Feature List (Text)
     *
     * @var string Features or modules provided by this application (and possibly required by other applications).
     */
    protected $featureListText;
    /**
     * Feature List (URL)
     *
     * @var string Features or modules provided by this application (and possibly required by other applications).
     */
    protected $featureListURL;
    /**
     * File Format
     *
     * @var string MIME format of the binary (e.g. application/zip).
     */
    protected $fileFormat;
    /**
     * File Size
     *
     * @var integer Size of the application / package (e.g. 18MB). In the absence of a unit (MB, KB etc.), KB will be assumed.
     */
    protected $fileSize;
    /**
     * Install Url
     *
     * @var string URL at which the app may be installed, if different from the URL of the item.
     */
    protected $installUrl;
    /**
     * Memory Requirements (Text)
     *
     * @var string Minimum memory requirements.
     */
    protected $memoryRequirementsText;
    /**
     * Memory Requirements (URL)
     *
     * @var string Minimum memory requirements.
     */
    protected $memoryRequirementsURL;
    /**
     * Operating System
     *
     * @var string Operating systems supported (Windows 7, OSX 10.6, Android 1.6).
     */
    protected $operatingSystem;
    /**
     * Permissions
     *
     * @var string Permission(s) required to run the app (for example, a mobile app may require full internet access or may run only on wifi).
     */
    protected $permissions;
    /**
     * Processor Requirements
     *
     * @var string Processor architecture required to run the application (e.g. IA64).
     */
    protected $processorRequirements;
    /**
     * Release Notes (Text)
     *
     * @var string Description of what changed in this version.
     */
    protected $releaseNotesText;
    /**
     * Release Notes (URL)
     *
     * @var string Description of what changed in this version.
     */
    protected $releaseNotesURL;
    /**
     * Requirements (Text)
     *
     * @var string Component dependency requirements for application. This includes runtime environments and shared libraries that are not included in the application distribution package, but required to run the application (Examples: DirectX, Java or .NET runtime).
     */
    protected $requirementsText;
    /**
     * Requirements (URL)
     *
     * @var string Component dependency requirements for application. This includes runtime environments and shared libraries that are not included in the application distribution package, but required to run the application (Examples: DirectX, Java or .NET runtime).
     */
    protected $requirementsURL;
    /**
     * Screenshot (ImageObject)
     *
     * @var ImageObject A link to a screenshot image of the app.
     */
    protected $screenshotImageObject;
    /**
     * Screenshot (URL)
     *
     * @var string A link to a screenshot image of the app.
     */
    protected $screenshotURL;
    /**
     * Software Version
     *
     * @var string Version of the software instance.
     */
    protected $softwareVersion;
    /**
     * Storage Requirements (Text)
     *
     * @var string Storage requirements (free space required).
     */
    protected $storageRequirementsText;
    /**
     * Storage Requirements (URL)
     *
     * @var string Storage requirements (free space required).
     */
    protected $storageRequirementsURL;
}
