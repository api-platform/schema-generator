<?php

/*
 * This file is part of the API Platform project.
 *
 * (c) Kévin Dunglas <dunglas@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\SchemaGenerator\OpenApi;

use cebe\openapi\spec\Schema;

trait SchemaTraversalTrait
{
    /**
     * @return \Generator<int, Schema>
     */
    private function getSchemaItem(Schema $schema): \Generator
    {
        if (!$schema->oneOf && !$schema->allOf) {
            yield $schema;

            return;
        }

        if ($schema->oneOf) {
            // Only use the first oneOf item. Needs to be improved.
            $oneOfSchema = $schema->oneOf[0];
            \assert($oneOfSchema instanceof Schema);
            foreach ($this->getSchemaItem($oneOfSchema) as $schemaItem) {
                yield $schemaItem;
            }
        }

        foreach ($schema->allOf ?? [] as $allOfSchema) {
            \assert($allOfSchema instanceof Schema);
            foreach ($this->getSchemaItem($allOfSchema) as $schemaItem) {
                yield $schemaItem;
            }
        }

        // Once all items have been used, yield the main schema in case there are some properties in it.
        yield $schema;
    }
}
