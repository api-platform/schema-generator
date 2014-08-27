<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Intended audience for an item, i.e. the group for whom the item was created.
 * 
 * @see http://schema.org/Audience Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Audience extends Intangible
{
    /**
     * @type string $audienceType The target group associated with a given audience (e.g. veterans, car owners, musicians, etc.)
          domain: Audience
          Range: Text
        
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $audienceType;
    /**
     * @type AdministrativeArea $geographicArea The geographic area associated with the audience.
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $geographicArea;
}
