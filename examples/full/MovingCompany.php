<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Moving Company
 * 
 * @link http://schema.org/MovingCompany
 * 
 * @ORM\Entity
 */
class MovingCompany extends HomeAndConstructionBusiness
{
}
