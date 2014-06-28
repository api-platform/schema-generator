<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * API Reference
 * 
 * @link http://schema.org/APIReference
 * 
 * @ORM\Entity
 */
class APIReference extends TechArticle
{
    /**
     * Assembly
     * 
     * @var string $assembly Library file name e.g., mscorlib.dll, system.web.dll
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $assembly;
    /**
     * Assembly Version
     * 
     * @var string $assemblyVersion Associated product/technology version. e.g., .NET Framework 4.5
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $assemblyVersion;
    /**
     * Programming Model
     * 
     * @var string $programmingModel Indicates whether API is managed or unmanaged.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $programmingModel;
    /**
     * Target Platform
     * 
     * @var string $targetPlatform Type of app development: phone, Metro style, desktop, XBox, etc.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $targetPlatform;
}
