<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A private parcel service as the delivery mode available for a certain offer.
 * 
 *     Commonly used values:
 * 
 *     http://purl.org/goodrelations/v1#DHL
 *     http://purl.org/goodrelations/v1#FederalExpress
 *     http://purl.org/goodrelations/v1#UPS
 *       
 * 
 * @see http://schema.org/ParcelService Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ParcelService extends DeliveryMethod
{
}
