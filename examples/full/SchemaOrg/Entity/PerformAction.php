<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of participating in performance arts.
 * 
 * @see http://schema.org/PerformAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PerformAction extends PlayAction
{
    /**
     * @type EntertainmentBusiness $entertainmentBusiness A sub property of location. The entertainment business where the action occurred.
     * @ORM\ManyToOne(targetEntity="EntertainmentBusiness")
     */
    private $entertainmentBusiness;
}
