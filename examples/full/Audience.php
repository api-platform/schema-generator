<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Audience
 * 
 * @link http://schema.org/Audience
 * 
 * @ORM\MappedSuperclass
 */
class Audience extends Intangible
{
    /**
     * Audience Type
     * 
     * @var string $audienceType The target group associated with a given audience (e.g. veterans, car owners, musicians, etc.)
      domain: Audience
      Range: Text
    
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $audienceType;
    /**
     * Geographic Area
     * 
     * @var AdministrativeArea $geographicArea The geographic area associated with the audience.
     * 
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $geographicArea;
}
