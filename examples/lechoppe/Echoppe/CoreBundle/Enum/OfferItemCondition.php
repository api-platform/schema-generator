<?php

/*
 * This file is part of the L'Échoppe package.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Echoppe\CoreBundle\Enum;

use MyCLabs\Enum\Enum;

/**
 * A list of possible conditions for the item.
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/OfferItemCondition Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class OfferItemCondition extends Enum
{
    /**
     * @type string DAMAGED_CONDITION Indicates that the item is damaged.
    */
    const DAMAGED_CONDITION = 'http://schema.org/DamagedCondition';
    /**
     * @type string NEW_CONDITION Indicates that the item is new.
    */
    const NEW_CONDITION = 'http://schema.org/NewCondition';
    /**
     * @type string REFURBISHED_CONDITION Indicates that the item is refurbished.
    */
    const REFURBISHED_CONDITION = 'http://schema.org/RefurbishedCondition';
    /**
     * @type string USED_CONDITION Indicates that the item is used.
    */
    const USED_CONDITION = 'http://schema.org/UsedCondition';
}
