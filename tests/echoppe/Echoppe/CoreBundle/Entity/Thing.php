<?php

/*
 * This file is part of the Échoppe package.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Echoppe\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Echoppe\CoreBundle\Model\ThingInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * {@inheritdoc}
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @ORM\MappedSuperclass
 */
class Thing implements ThingInterface
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

    /**
     * Sets description.
     *
     * @param  string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
    * Gets description.
    *
    * @return string
    */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Sets name.
     *
     * @param  string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
    * Gets name.
    *
    * @return string
    */
    public function getName()
    {
        return $this->name;
    }
}
