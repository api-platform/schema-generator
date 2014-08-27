<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A house painting service.
 * 
 * @see http://schema.org/HousePainter Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class HousePainter extends HomeAndConstructionBusiness
{
}
