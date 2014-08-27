<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A dataset in downloadable form.
 * 
 * @see http://schema.org/DataDownload Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DataDownload extends MediaObject
{
}
