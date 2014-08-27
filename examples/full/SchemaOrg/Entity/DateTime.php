<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A combination of date and time of day in the form [-]CCYY-MM-DDThh:mm:ss[Z|(+|-)hh:mm] (see Chapter 5.4 of ISO 8601).
 * 
 * @see http://schema.org/DateTime Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DateTime extends DataType
{
}
