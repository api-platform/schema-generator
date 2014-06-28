<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Organization
 * 
 * @link http://schema.org/MedicalOrganization
 * 
 * @ORM\MappedSuperclass
 */
class MedicalOrganization extends LocalBusiness
{
}
