#!/bin/sh
rm -Rf examples/full/ examples/lechoppe/
mkdir examples/full/ examples/lechoppe/
php bin/schema.php schema:dump-configuration
php bin/schema.php schema:extract-cardinalities
php bin/schema.php schema:generate-types examples/full/
php bin/schema.php schema:generate-types examples/lechoppe/ examples/config/lechoppe.yml