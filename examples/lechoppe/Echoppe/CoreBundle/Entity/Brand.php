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

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * A brand is a name used by an organization or business person for labeling a product, product group, or similar.
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/Brand Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Brand extends Thing
{
    /**
     * @type ImageObject $logo A logo associated with an organization.
     * @ORM\ManyToOne(targetEntity="ImageObject")
     */
    private $logo;
}
