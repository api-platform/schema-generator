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
 * Brand
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/Brand
 */
class Brand extends Intangible
{
    /**
     * Logo (URL)
     *
     * @var string A logo associated with an organization.
     */
    protected $logoURL;
    /**
     * Logo (ImageObject)
     *
     * @var ImageObject A logo associated with an organization.
     */
    protected $logoImageObject;
}
