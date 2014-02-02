<?php

namespace SchemaOrg;

/**
 * Drug Strength
 *
 * @link http://schema.org/DrugStrength
 */
class DrugStrength extends MedicalIntangible
{
    /**
     * Active Ingredient
     *
     * @var string An active ingredient, typically chemical compounds and/or biologic substances.
     */
    protected $activeIngredient;
    /**
     * Available in
     *
     * @var AdministrativeArea The location in which the strength is available.
     */
    protected $availableIn;
    /**
     * Strength Unit
     *
     * @var string The units of an active ingredient's strength, e.g. mg.
     */
    protected $strengthUnit;
    /**
     * Strength Value
     *
     * @var float The value of an active ingredient's strength, e.g. 325.
     */
    protected $strengthValue;
}
