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
 * A list of possible product availability options.
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/ItemAvailability Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ItemAvailability extends Enumeration
{
}
