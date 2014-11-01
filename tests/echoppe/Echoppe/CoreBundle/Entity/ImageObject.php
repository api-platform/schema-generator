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
use Echoppe\CoreBundle\Model\ImageObjectInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * {@inheritdoc}
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @ORM\MappedSuperclass
 */
class ImageObject extends Thing implements ImageObjectInterface
{
    /**
     * @type string $caption The caption for this object.
     * @Assert\Type(type="string")
     * @ORM\Column
     */
    private $caption;

    /**
     * Sets caption.
     *
     * @param  string $caption
     * @return $this
     */
    public function setCaption($caption)
    {
        $this->caption = $caption;

        return $this;
    }

    /**
    * Gets caption.
    *
    * @return string
    */
    public function getCaption()
    {
        return $this->caption;
    }
}
