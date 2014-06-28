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
 * Thing
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/Thing
 * 
 * @ORM\MappedSuperclass
 */
class Thing
{
    /**
     * Description
     * 
     * @var string $description A short description of the item.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $description;
    /**
     * Image
     * 
     * @var string $image URL of an image of the item.
     * 
     * @Assert\Url
     * @ORM\Column
     */
    private $image;
    /**
     * Name
     * 
     * @var string $name The name of the item.
     * 
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $name;
}
