<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Physical Exam
 * 
 * @link http://schema.org/PhysicalExam
 * 
 * @ORM\Entity
 */
class PhysicalExam extends MedicalEnumeration
{
}
