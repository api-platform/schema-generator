<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Real Estate Agent
 * 
 * @link http://schema.org/RealEstateAgent
 * 
 * @ORM\Entity
 */
class RealEstateAgent extends LocalBusiness
{
}
