<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A structured value representing the duration and scope of services that will be provided to a customer free of charge in case of a defect or malfunction of a product.
 * 
 * @see http://schema.org/WarrantyPromise Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WarrantyPromise extends StructuredValue
{
    /**
     * @type QuantitativeValue $durationOfWarranty The duration of the warranty promise. Common unitCode values are ANN for year, MON for months, or DAY for days.
     * @ORM\ManyToOne(targetEntity="QuantitativeValue")
     * @ORM\JoinColumn(nullable=false)
     */
    private $durationOfWarranty;
    /**
     * @type WarrantyScope $warrantyScope The scope of the warranty promise.
     * @ORM\OneToOne(targetEntity="WarrantyScope")
     */
    private $warrantyScope;
}
