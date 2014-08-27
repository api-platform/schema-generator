<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of editing a recipient by removing one of its objects.
 * 
 * @see http://schema.org/DeleteAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DeleteAction extends UpdateAction
{
}
