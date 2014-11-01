<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A PerformanceRole is a Role that some entity places with regard to a theatrical performance, e.g. in a Movie, TVSeries etc.
 * 
 * @see http://schema.org/PerformanceRole Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PerformanceRole extends Role
{
    /**
     */
    private $characterName;
}
