#!/bin/bash -e

# Test commands
bin/schema dump-configuration
bin/schema extract-cardinalities

# Build models
rm -Rf build/
mkdir -p build/ecommerce/ build/address-book/ build/vgo/
bin/schema generate-types build/address-book/ tests/config/address-book.yml
bin/schema generate-types build/ecommerce/ tests/config/ecommerce.yml
bin/schema generate-types build/vgo/ tests/config/vgo.yml

# Check code CS
vendor/bin/php-cs-fixer --dry-run --diff -vvv fix src/

# Check CS of generated models CS
vendor/bin/php-cs-fixer --dry-run --diff -vvv fix build/
