<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An entry point, within some Web-based protocol.
 * 
 * @see http://schema.org/EntryPoint Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class EntryPoint extends Intangible
{
    /**
     */
    private $httpMethod;
    /**
     */
    private $encodingType;
    /**
     */
    private $contentType;
    /**
     */
    private $application;
    /**
     */
    private $urlTemplate;
}
