<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Web page type: Checkout page.
 * 
 * @see http://schema.org/CheckoutPage Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CheckoutPage extends WebPage
{
}
