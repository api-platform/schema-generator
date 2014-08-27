<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A theater or other performing art center.
 * 
 * @see http://schema.org/PerformingArtsTheater Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PerformingArtsTheater extends CivicStructure
{
}
