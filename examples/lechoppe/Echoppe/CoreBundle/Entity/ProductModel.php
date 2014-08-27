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
 * A datasheet or vendor specification of a product (in the sense of a prototypical description).
 * 
 * @author Kévin Dunglas <dunglas@gmail.com>
 * @see http://schema.org/ProductModel Documentation on Schema.org
 * 
 * @ORM\MappedSuperclass
 */
class ProductModel extends Product
{
    /**
     * @type ProductModel $isVariantOf A pointer to a base product from which this product is a variant. It is safe to infer that the variant inherits all product features from the base model, unless defined locally. This is not transitive.
     * @ORM\OneToOne(targetEntity="ProductModel")
     */
    private $isVariantOf;
}
