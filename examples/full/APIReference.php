<?php

namespace SchemaOrg;

/**
 * API Reference
 *
 * @link http://schema.org/APIReference
 */
class APIReference extends TechArticle
{
    /**
     * Assembly
     *
     * @var string Library file name e.g., mscorlib.dll, system.web.dll
     */
    protected $assembly;
    /**
     * Assembly Version
     *
     * @var string Associated product/technology version. e.g., .NET Framework 4.5
     */
    protected $assemblyVersion;
    /**
     * Programming Model
     *
     * @var string Indicates whether API is managed or unmanaged.
     */
    protected $programmingModel;
    /**
     * Target Platform
     *
     * @var string Type of app development: phone, Metro style, desktop, XBox, etc.
     */
    protected $targetPlatform;
}
