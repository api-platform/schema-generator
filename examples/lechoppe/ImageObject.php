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
 * Image Object
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/ImageObject
 */
class ImageObject extends MediaObject
{
    /**
     * Caption
     *
     * @var string The caption for this object.
     */
    protected $caption;
}
