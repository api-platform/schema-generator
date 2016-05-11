#!/bin/bash -e

# Test commands
bin/schema dump-configuration
bin/schema extract-cardinalities

# Build models
rm -Rf build/
mkdir -p build/address-book/ build/blog/ build/ecommerce/ build/vgo/
bin/schema generate-types build/address-book/ tests/config/address-book.yml
bin/schema generate-types build/blog/ tests/config/blog.yml
bin/schema generate-types build/ecommerce/ tests/config/ecommerce.yml
bin/schema generate-types build/vgo/ tests/config/vgo.yml

mkdir -p build/mongodb/ecommerce/ build/mongodb/address-book/
bin/schema generate-types build/mongodb/address-book/ tests/config/mongodb/address-book.yml
bin/schema generate-types build/mongodb/ecommerce/ tests/config/mongodb/ecommerce.yml

# Check code CS
vendor/bin/php-cs-fixer --dry-run --diff -vvv fix src/

# Check CS of generated models CS
vendor/bin/php-cs-fixer --dry-run --diff -vvv fix build/
