<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A condition or factor that serves as a reason to withhold a certain medical therapy. Contraindications can be absolute (there are no reasonable circumstances for undertaking a course of action) or relative (the patient is at higher risk of complications, but that these risks may be outweighed by other considerations or mitigated by other measures).
 * 
 * @see http://schema.org/MedicalContraindication Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class MedicalContraindication extends MedicalEntity
{
}
