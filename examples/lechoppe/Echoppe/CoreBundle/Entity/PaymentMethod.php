<?php

/*
 * This file is part of the L'Échoppe package.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Echoppe\CoreBundle\Entity;


/**
 * A payment method is a standardized procedure for transferring the monetary amount for a purchase. Payment methods are characterized by the legal and technical structures used, and by the organization or group carrying out the transaction.
 * 
 *     Commonly used values:
 * 
 *     http://purl.org/goodrelations/v1#ByBankTransferInAdvance
 *     http://purl.org/goodrelations/v1#ByInvoice
 *     http://purl.org/goodrelations/v1#Cash
 *     http://purl.org/goodrelations/v1#CheckInAdvance
 *     http://purl.org/goodrelations/v1#COD
 *     http://purl.org/goodrelations/v1#DirectDebit
 *     http://purl.org/goodrelations/v1#GoogleCheckout
 *     http://purl.org/goodrelations/v1#PayPal
 *     http://purl.org/goodrelations/v1#PaySwarm
 *     		
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/PaymentMethod Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class PaymentMethod extends Enumeration
{
}
