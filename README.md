# PHP Schema.org Model

Various tools to generate a data model based on [Schema.org](http://schema.org) vocables.

## Installation



## Cardinality extractor

Extracts property's cardinality.
[GoodRelations](http://www.heppnetz.de/projects/goodrelations/) data are used when applicable. Other cardinalities are guessed using the property's comment.
When the cardinality cannot be automatically extracted, it's value is set to `unknown`.

Usage:
    php bin/console.php schema:extract-cardinality

