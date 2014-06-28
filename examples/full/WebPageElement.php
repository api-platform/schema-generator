<?php


namespace SchemaOrg;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Web Page Element
 * 
 * @link http://schema.org/WebPageElement
 * 
 * @ORM\MappedSuperclass
 */
class WebPageElement extends CreativeWork
{
}
