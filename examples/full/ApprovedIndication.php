<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Approved Indication
 * 
 * @link http://schema.org/ApprovedIndication
 * 
 * @ORM\Entity
 */
class ApprovedIndication extends MedicalIndication
{
}
