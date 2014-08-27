<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of finding an object.<p>Related actions:</p><ul><li><a href="http://schema.org/SearchAction">SearchAction</a>: FindAction is generally lead by a SearchAction, but not necessarily.</li></ul>
 * 
 * @see http://schema.org/FindAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class FindAction extends Action
{
}
