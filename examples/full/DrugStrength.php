<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Drug Strength
 * 
 * @link http://schema.org/DrugStrength
 * 
 * @ORM\Entity
 */
class DrugStrength extends MedicalIntangible
{
    /**
     * Active Ingredient
     * 
     * @var string $activeIngredient An active ingredient, typically chemical compounds and/or biologic substances.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $activeIngredient;
    /**
     * Available in
     * 
     * @var AdministrativeArea $availableIn The location in which the strength is available.
     * 
     * @ORM\ManyToOne(targetEntity="AdministrativeArea")
     * @ORM\JoinColumn(nullable=false)
     */
    private $availableIn;
    /**
     * Strength Unit
     * 
     * @var string $strengthUnit The units of an active ingredient's strength, e.g. mg.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $strengthUnit;
    /**
     * Strength Value
     * 
     * @var float $strengthValue The value of an active ingredient's strength, e.g. 325.
     * 
     * @Assert\Type(type="float")
     * @ORM\Column(type="float")
     */
    private $strengthValue;
}
