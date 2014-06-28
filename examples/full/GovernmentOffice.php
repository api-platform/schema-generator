<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Government Office
 * 
 * @link http://schema.org/GovernmentOffice
 * 
 * @ORM\MappedSuperclass
 */
class GovernmentOffice extends LocalBusiness
{
}
