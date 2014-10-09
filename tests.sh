#!/bin/sh
rm -Rf examples/full/ examples/echoppe/
mkdir examples/full/ examples/echoppe/
php bin/schema.php schema:dump-configuration
php bin/schema.php schema:extract-cardinalities
php bin/schema.php schema:generate-types examples/full/
php bin/schema.php schema:generate-types examples/echoppe/ examples/config/echoppe.yml
