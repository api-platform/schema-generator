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
     */
    private $assembly;
    /**
     */
    private $assemblyVersion;
    /**
     */
    private $programmingModel;
    /**
     */
    private $targetPlatform;
}
