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
use Echoppe\CoreBundle\Model\ProductModelInterface;

/**
 * {@inheritdoc}
 *
 * @author Kévin Dunglas <dunglas@gmail.com>
 *
 * @ORM\MappedSuperclass
 */
class ProductModel extends Product implements ProductModelInterface
{
    /**
     * @type ProductModelInterface $isVariantOf A pointer to a base product from which this product is a variant. It is safe to infer that the variant inherits all product features from the base model, unless defined locally. This is not transitive.
     * @ORM\OneToOne(targetEntity="ProductModelInterface")
     */
    private $isVariantOf;

    /**
     * Sets isVariantOf.
     *
     * @param  ProductModelInterface $isVariantOf
     * @return $this
     */
    public function setIsVariantOf(ProductModelInterface $isVariantOf)
    {
        $this->isVariantOf = $isVariantOf;

        return $this;
    }

    /**
    * Gets isVariantOf.
    *
    * @return ProductModelInterface
    */
    public function getIsVariantOf()
    {
        return $this->isVariantOf;
    }
}
