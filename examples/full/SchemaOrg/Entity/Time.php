<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A point in time recurring on multiple days in the form hh:mm:ss[Z|(+|-)hh:mm] (see <a href="http://www.w3.org/TR/xmlschema-2/#time">XML schema for details</a>).
 * 
 * @see http://schema.org/Time Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Time extends DataType
{
}
