<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of capturing still images of objects using a camera.
 * 
 * @see http://schema.org/PhotographAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PhotographAction extends CreateAction
{
}
