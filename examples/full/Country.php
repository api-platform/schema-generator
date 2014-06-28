<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 * 
 * @link http://schema.org/Country
 * 
 * @ORM\Entity
 */
class Country extends AdministrativeArea
{
}
