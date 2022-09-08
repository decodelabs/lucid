# Lucid

[![PHP from Packagist](https://img.shields.io/packagist/php-v/decodelabs/lucid?style=flat)](https://packagist.org/packages/decodelabs/lucid)
[![Latest Version](https://img.shields.io/packagist/v/decodelabs/lucid.svg?style=flat)](https://packagist.org/packages/decodelabs/lucid)
[![Total Downloads](https://img.shields.io/packagist/dt/decodelabs/lucid.svg?style=flat)](https://packagist.org/packages/decodelabs/lucid)
[![GitHub Workflow Status](https://img.shields.io/github/workflow/status/decodelabs/lucid/Integrate)](https://github.com/decodelabs/lucid/actions/workflows/integrate.yml)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-44CC11.svg?longCache=true&style=flat)](https://github.com/phpstan/phpstan)
[![License](https://img.shields.io/packagist/l/decodelabs/lucid?style=flat)](https://packagist.org/packages/decodelabs/lucid)

Flexible and expansive sanitisation and validation framework for PHP


## Installation

Install the library via composer:

```bash
composer require decodelabs/lucid
```

## Usage

Lucid provides a unified single-value sanitisation and validation structure for making sure your input makes sense.

```php
use DecodeLabs\Lucid;

// This ensures the value is a string
$myString = Lucid::make('This is a string', 'string');

// This is nullable
$notAString = Lucid::make(null, '?string');

// These are constraints - throws an exception
$myString = Lucid::make('My very long piece of text', 'string', [
    'maxLength' => 10,
    'maxWords' => 4
]);

// Creates an instance of Carbon (DateTime)
$myDate = Lucid::make('tomorrow', 'date', [
    'min' => 'yesterday',
    'max' => '+3 days'
]);
```

If you need more fine grained control of the responses to constraints, use <code>validate()</code>:

```php
$result = Lucid::validate('int', 'potato', [
    'min' => 4
]);

if(!$result->isValid()) {
    // Do something with the potato

    foreach($result->getErrors() as $error) {
        echo $error->getMessage();
    }
}
```

Or conversely if you just need a yes or no answer, use <code>is()</code>:

```php
if(!Lucid::validate('not a number', 'float')) {
    // do something
}
```

### Importing

Atlas uses [Veneer](https://github.com/decodelabs/veneer) to provide a unified frontage under <code>DecodeLabs\Atlas</code>.
You can access all the primary functionality via this static frontage without compromising testing and dependency injection.


## Custom processors

Lucid uses [Archetype](https://github.com/decodelabs/archetype) to load both <code>Processors</code> and <code>Constraints</code> - implement your own custom classes within <code>DecodeLabs\Lucid\Processor</code> or <code>DecodeLabs\Lucid\Constraint</code> namespaces, or create your own Archetype <code>Resolver</code> to load them from elsewhere.

Please see the selection of existing implementations for details on how to build your own custom classes.


## Provider interfaces

Lucid builds on a sub-package, [Lucid Support](https://github.com/decodelabs/lucid-support) which makes available a set of <code>Provider</code> interfaces to enable embedded implementations of the Sanitizer structure.

Please see the readme in [Lucid Support](https://github.com/decodelabs/lucid-support) for integrating Lucid into your own libraries.


## Licensing
Lucid is licensed under the MIT License. See [LICENSE](./LICENSE) for the full license text.
