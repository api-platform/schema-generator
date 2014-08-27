<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A publication in any medium issued in successive parts bearing numerical or chronological designations and intended, such as a magazine, scholarly journal, or newspaper to continue indefinitely.
 * 
 * @see http://schema.org/Periodical Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Periodical extends CreativeWork
{
    /**
     * @type string $issn The International Standard Serial Number (ISSN) that identifies this periodical. You can repeat this property to (for example) identify different formats of this periodical.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $issn;
}
