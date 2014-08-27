<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of capturing sound and moving images on film, video, or digitally.
 * 
 * @see http://schema.org/FilmAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class FilmAction extends CreateAction
{
}
