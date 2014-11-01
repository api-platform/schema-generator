<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Computer programming source code. Example: Full (compile ready) solutions, code snippet samples, scripts, templates.
 * 
 * @see http://schema.org/Code Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Code extends CreativeWork
{
    /**
     */
    private $codeRepository;
    /**
     */
    private $programmingLanguage;
    /**
     */
    private $runtime;
    /**
     */
    private $sampleType;
    /**
     */
    private $targetProduct;
}
