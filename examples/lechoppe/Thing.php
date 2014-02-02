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
 * Thing
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/Thing
 */
class Thing
{
    /**
     * Description
     *
     * @var string A short description of the item.
     */
    protected $description;
    /**
     * Image
     *
     * @var string URL of an image of the item.
     */
    protected $image;
    /**
     * Name
     *
     * @var string The name of the item.
     */
    protected $name;
}
