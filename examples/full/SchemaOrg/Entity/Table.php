<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A table on a Web page.
 * 
 * @see http://schema.org/Table Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Table extends WebPageElement
{
}
