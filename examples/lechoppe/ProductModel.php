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
 * Product Model
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @link http://schema.org/ProductModel
 * 
 * @ORM\Entity
 */
class ProductModel extends Product
{
    /**
     * Is Variant of
     * 
     * @var ProductModel $isVariantOf A pointer to a base product from which this product is a variant. It is safe to infer that the variant inherits all product features from the base model, unless defined locally. This is not transitive.
     * 
     * @ORM\OneToOne(targetEntity="ProductModel")
     */
    private $isVariantOf;
}
