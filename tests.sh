#!/bin/sh
rm -Rf examples/full/ examples/lechoppe/
mkdir examples/full/ examples/lechoppe/
php bin/schema.php schema:dump-configuration
php bin/schema.php schema:extract-cardinalities
php bin/schema.php schema:generate-entities examples/full/
php bin/schema.php schema:generate-entities examples/lechoppe/ examples/config/lechoppe.yml