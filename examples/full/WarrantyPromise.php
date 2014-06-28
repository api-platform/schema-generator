<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Warranty Promise
 * 
 * @link http://schema.org/WarrantyPromise
 * 
 * @ORM\Entity
 */
class WarrantyPromise extends StructuredValue
{
    /**
     * Duration of Warranty
     * 
     * @var QuantitativeValue $durationOfWarranty The duration of the warranty promise. Common unitCode values are ANN for year, MON for months, or DAY for days.
     * 
     * @ORM\ManyToOne(targetEntity="QuantitativeValue")
     * @ORM\JoinColumn(nullable=false)
     */
    private $durationOfWarranty;
    /**
     * Warranty Scope
     * 
     * @var WarrantyScope $warrantyScope The scope of the warranty promise.
     * 
     * @ORM\OneToOne(targetEntity="WarrantyScope")
     */
    private $warrantyScope;
}
