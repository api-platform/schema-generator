<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Reference documentation for application programming interfaces (APIs).
 * 
 * @see http://schema.org/APIReference Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class APIReference extends TechArticle
{
    /**
     * @type string $assembly Library file name e.g., mscorlib.dll, system.web.dll
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $assembly;
    /**
     * @type string $assemblyVersion Associated product/technology version. e.g., .NET Framework 4.5
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $assemblyVersion;
    /**
     * @type string $programmingModel Indicates whether API is managed or unmanaged.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $programmingModel;
    /**
     * @type string $targetPlatform Type of app development: phone, Metro style, desktop, XBox, etc.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $targetPlatform;
}
