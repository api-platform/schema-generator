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
     * @type string $httpMethod An HTTP method that specifies the appropriate HTTP method for a request to an HTTP EntryPoint. Values are capitalized strings as used in HTTP.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $httpMethod;
    /**
     * @type string $encodingType The supported encoding type(s) for an EntryPoint request.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $encodingType;
    /**
     * @type string $contentType The supported content type(s) for an EntryPoint response.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $contentType;
    /**
     * @type SoftwareApplication $application An application that can complete the request.
     * @ORM\ManyToOne(targetEntity="SoftwareApplication")
     */
    private $application;
    /**
     * @type string $urlTemplate An url template (RFC6570) that will be used to construct the target of the execution of the action.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $urlTemplate;
}
