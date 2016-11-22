# Changelog

## 1.2.0

* The default config now match the Symfony's and API Platform's Best Practices (namespaces)
* The API Platform's annotation generator is enabled by default
* Use HTTPS to retrieve vocabularies by default
* Properties are generated in the order of the config file
* Properties and constants are separated by an empty line

## 1.1.2

* Fix a bug when generating enumerations

## 1.1.1

* Use the new PHP CS Fixer package

## 1.1.0

* MongoDB support
* API Platform Core v2 support
* Schema Generator is now available as PHAR
* Support any RDF vocabulary (was previously limited to Schema.org)
* Support for custom classes
* Support for [Doctrine Embeddables](http://doctrine-orm.readthedocs.io/projects/doctrine-orm/en/latest/tutorials/embeddables.html)
* Support for serialization groups
* Support for the `nullable` option
* Support for the `unique` option
* Support for custom Doctine `@Column` annotations
* Symfony 3.0 compatibility
* Various bug fixes and improved tests

## 1.0.0

* Rename the package API Platform Schema Generator (formerly PHP Schema)
* Support for external and custom RDFa schemas
* Support custom name for relation tables
* Allow to use properties from parent classes
* Allow to create custom fields
* Improve code quality and tests

## 0.4.3

* Fix compatibility with [API Platform Core](https://github.com/api-platform/core) v1 (formerly DunglasJsonLdApiBundle)

## 0.4.2

* Fix compatibility with [API Platform Core](https://github.com/api-platform/core) v1 (formerly DunglasJsonLdApiBundle)

## 0.4.1

* Make CS fixer working again

## 0.4.0

* [API Platform Core](https://github.com/api-platform/core) v1 (formerly DunglasJsonLdApiBundle) support

## 0.3.2

* Fixed Doctrine relations handling
* Better `null` value handling

## 0.3.1

* Fix a bug when using Doctrine `ArrayCollection`
* Don't call `parent::__construct()`` when the parent constructor doesn't exist

## 0.3.0

* Symfony / Doctrine's ResolveTragetEntityListener config mapping generation
* Refactored Doctrine config
* Removed deprecated call to `YAML::parse()``

## 0.2.0

* Better generated PHPDoc
* Removed `@type` support
