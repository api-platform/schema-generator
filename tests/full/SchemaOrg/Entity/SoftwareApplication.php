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
     */
    private $applicationCategory;
    /**
     */
    private $applicationSubCategory;
    /**
     */
    private $applicationSuite;
    /**
     */
    private $countriesNotSupported;
    /**
     */
    private $countriesSupported;
    /**
     */
    private $device;
    /**
     */
    private $downloadUrl;
    /**
     */
    private $featureList;
    /**
     */
    private $fileFormat;
    /**
     */
    private $fileSize;
    /**
     */
    private $installUrl;
    /**
     */
    private $memoryRequirements;
    /**
     */
    private $operatingSystem;
    /**
     */
    private $permissions;
    /**
     */
    private $processorRequirements;
    /**
     */
    private $releaseNotes;
    /**
     */
    private $requirements;
    /**
     */
    private $screenshot;
    /**
     */
    private $softwareVersion;
    /**
     */
    private $storageRequirements;
}
