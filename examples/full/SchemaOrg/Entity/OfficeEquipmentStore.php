<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * An office equipment store.
 * 
 * @see http://schema.org/OfficeEquipmentStore Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OfficeEquipmentStore extends Store
{
}
