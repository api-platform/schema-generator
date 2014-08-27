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
 * A delivery method is a standardized procedure for transferring the product or service to the destination of fulfillment chosen by the customer. Delivery methods are characterized by the means of transportation used, and by the organization or group that is the contracting party for the sending organization or person.
 * 
 *     Commonly used values:
 * 
 *     http://purl.org/goodrelations/v1#DeliveryModeDirectDownload
 *     http://purl.org/goodrelations/v1#DeliveryModeFreight
 *     http://purl.org/goodrelations/v1#DeliveryModeMail
 *     http://purl.org/goodrelations/v1#DeliveryModeOwnFleet
 *     http://purl.org/goodrelations/v1#DeliveryModePickUp
 *     http://purl.org/goodrelations/v1#DHL
 *     http://purl.org/goodrelations/v1#FederalExpress
 *     http://purl.org/goodrelations/v1#UPS
 *     		
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/DeliveryMethod Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class DeliveryMethod extends Enumeration
{
}
