<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * On Site Pickup
 * 
 * @link http://schema.org/OnSitePickup
 * 
 * @ORM\Entity
 */
class OnSitePickup extends DeliveryMethod
{
}
