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

namespace ApiPlatform\SchemaGenerator;

/**
 * Holder of static configuration for the current run of Schema Generator.
 *
 * @author d3fk::Angatar
 */
class SchemaGeneratorConfigurationHolder
{
    /**
     * @var array<string, mixed>
     */
    public static array $config = [];

    /**
     * Sets the static configuration.
     *
     * @param array <string, mixed> $config
     */
    public static function set(array $config): void
    {
        self::$config = $config;
    }

    /**
     * Gets the static configuration set.
     *
     * @return array<string, mixed> $config
     */
    public static function get(): array
    {
        return self::$config;
    }

    /**
     * Returns true if the configuration was set and is ready to be used.
     */
    public static function isReady(): bool
    {
        if (empty(self::$config)) {
            return false;
        }

        return true;
    }

    /**
     * Flushes any stored configuration.
     */
    public static function reset(): void
    {
        self::$config = [];
    }
}
