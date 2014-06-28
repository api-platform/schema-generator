<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Brand
 * 
 * @link http://schema.org/Brand
 * 
 * @ORM\Entity
 */
class Brand extends Intangible
{
    /**
     * Logo
     * 
     * @var string $logo A logo associated with an organization.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $logo;
}
