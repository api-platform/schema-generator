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
 * The most generic type of item.
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/Thing Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class Thing
{
    /**
     * @type string $description A short description of the item.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $description;
    /**
     * @type string $name The name of the item.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $name;
}
