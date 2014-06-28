<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Store
 * 
 * @link http://schema.org/Store
 * 
 * @ORM\MappedSuperclass
 */
class Store extends LocalBusiness
{
}
