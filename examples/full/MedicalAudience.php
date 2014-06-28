<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Medical Audience
 * 
 * @link http://schema.org/MedicalAudience
 * 
 * @ORM\Entity
 */
class MedicalAudience extends PeopleAudience
{
}
