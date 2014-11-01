<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A medical laboratory that offers on-site or off-site diagnostic services.
 * 
 * @see http://schema.org/DiagnosticLab Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DiagnosticLab extends MedicalOrganization
{
    /**
     */
    private $availableTest;
}
