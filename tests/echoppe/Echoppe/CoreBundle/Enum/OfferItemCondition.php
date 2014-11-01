<?php

/*
 * This file is part of the Échoppe package.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Echoppe\CoreBundle\Enum;

/**
 * A list of possible conditions for the item.
 *
 * @see http://schema.org/OfferItemCondition Documentation on Schema.org
 * @author Kévin Dunglas <dunglas@gmail.com>
 */
class OfferItemCondition extends Enum
{
    /**
     * @type string DamagedCondition
     */
    const DAMAGED_CONDITION = 'http://schema.org/DamagedCondition';
    /**
     * @type string NewCondition
     */
    const NEW_CONDITION = 'http://schema.org/NewCondition';
    /**
     * @type string RefurbishedCondition
     */
    const REFURBISHED_CONDITION = 'http://schema.org/RefurbishedCondition';
    /**
     * @type string UsedCondition
     */
    const USED_CONDITION = 'http://schema.org/UsedCondition';
}
