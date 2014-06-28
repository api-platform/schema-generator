<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Professional Service
 * 
 * @link http://schema.org/ProfessionalService
 * 
 * @ORM\MappedSuperclass
 */
class ProfessionalService extends LocalBusiness
{
}
