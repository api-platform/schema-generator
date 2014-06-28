<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Administrative Area
 * 
 * @link http://schema.org/AdministrativeArea
 * 
 * @ORM\MappedSuperclass
 */
class AdministrativeArea extends Place
{
}
