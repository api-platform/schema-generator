#!/bin/sh

# Test commands
bin/schema schema:dump-configuration
bin/schema schema:extract-cardinalities

# Build models
rm -Rf build/
mkdir -p build/full/ build/ecommerce/
bin/schema schema:generate-types build/full/
bin/schema schema:generate-types build/ecommerce/ tests/config/ecommerce.yml

# Check code CS
vendor/bin/php-cs-fixer --dry-run --diff -vvv fix src/

# Check generated model CS
vendor/bin/php-cs-fixer --dry-run --diff -vvv fix build/full/
vendor/bin/php-cs-fixer --dry-run --diff -vvv fix build/ecommerce/
