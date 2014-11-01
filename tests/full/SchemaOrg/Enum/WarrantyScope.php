<?php


namespace SchemaOrg\Enum;


/**
 * A range of of services that will be provided to a customer free of charge in case of a defect or malfunction of a product.
 * 
 *     Commonly used values:
 * 
 *     http://purl.org/goodrelations/v1#Labor-BringIn
 *     http://purl.org/goodrelations/v1#PartsAndLabor-BringIn
 *     http://purl.org/goodrelations/v1#PartsAndLabor-PickUp
 *       
 * 
 * @see http://schema.org/WarrantyScope Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class WarrantyScope extends Enum
{
}
