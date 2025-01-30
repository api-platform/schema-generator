<?php

declare(strict_types=1);

namespace App\Schema\Enum;

use MyCLabs\Enum\Enum;

/**
 * An enumeration of genders.
 *
 * @see https://schema.org/GenderType
 */
class GenderType extends Enum
{
    /** @var string The male gender. */
    public const MALE = 'https://schema.org/Male';

    /** @var string The female gender. */
    public const FEMALE = 'https://schema.org/Female';
}
