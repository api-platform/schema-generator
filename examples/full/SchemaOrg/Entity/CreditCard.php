<?php


namespace SchemaOrg\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A credit or debit card type as a standardized procedure for transferring the monetary amount for a purchase.
 * 
 *     Commonly used values:
 * 
 *     http://purl.org/goodrelations/v1#AmericanExpress
 *     http://purl.org/goodrelations/v1#DinersClub
 *     http://purl.org/goodrelations/v1#Discover
 *     http://purl.org/goodrelations/v1#JCB
 *     http://purl.org/goodrelations/v1#MasterCard
 *     http://purl.org/goodrelations/v1#VISA
 *     		
 * 
 * @see http://schema.org/CreditCard Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class CreditCard extends PaymentMethod
{
}
