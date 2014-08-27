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
 * A list of possible conditions for the item.
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/OfferItemCondition Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OfferItemCondition extends Enumeration
{
}
