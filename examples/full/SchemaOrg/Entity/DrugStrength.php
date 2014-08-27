<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A specific strength in which a medical drug is available in a specific country.
 * 
 * @see http://schema.org/DrugStrength Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DrugStrength extends MedicalIntangible
{
    /**
     * @type string $activeIngredient An active ingredient, typically chemical compounds and/or biologic substances.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $activeIngredient;
    /**
     * @type AdministrativeArea $availableIn The location in which the strength is available.
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $availableIn;
    /**
     * @type string $strengthUnit The units of an active ingredient's strength, e.g. mg.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $strengthUnit;
    /**
     * @type float $strengthValue The value of an active ingredient's strength, e.g. 325.
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $strengthValue;
}
