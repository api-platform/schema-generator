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
use Echoppe\CoreBundle\Model\BrandInterface;
use Echoppe\CoreBundle\Model\ImageObjectInterface;

/**
 * {@inheritdoc}
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @ORM\MappedSuperclass
 */
class Brand extends Thing implements BrandInterface
{
    /**
     * @type ImageObjectInterface $logo A logo associated with an organization.
     * @ORM\ManyToOne(targetEntity="ImageObjectInterface")
     */
    private $logo;

    /**
     * Sets logo.
     *
     * @param  ImageObjectInterface $logo
     * @return $this
     */
    public function setLogo(ImageObjectInterface $logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
    * Gets logo.
    *
    * @return ImageObjectInterface
    */
    public function getLogo()
    {
        return $this->logo;
    }
}
