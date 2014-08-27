<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A brand is a name used by an organization or business person for labeling a product, product group, or similar.
 * 
 * @see http://schema.org/Brand Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Brand extends Intangible
{
    /**
     * @type ImageObject $logo A logo associated with an organization.
     * @ORM\ManyToOne(targetEntity="ImageObject")
     */
    private $logo;
}
