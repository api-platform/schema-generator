<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * The act of downloading an object.
 * 
 * @see http://schema.org/DownloadAction Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DownloadAction extends TransferAction
{
}
