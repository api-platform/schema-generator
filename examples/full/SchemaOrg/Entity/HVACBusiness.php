<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A business that provide Heating, Ventilation and Air Conditioning services.
 * 
 * @see http://schema.org/HVACBusiness Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class HVACBusiness extends HomeAndConstructionBusiness
{
}
