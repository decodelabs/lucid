# Lucid

[![PHP from Packagist](https://img.shields.io/packagist/php-v/decodelabs/lucid?style=flat)](https://packagist.org/packages/decodelabs/lucid)
[![Latest Version](https://img.shields.io/packagist/v/decodelabs/lucid.svg?style=flat)](https://packagist.org/packages/decodelabs/lucid)
[![Total Downloads](https://img.shields.io/packagist/dt/decodelabs/lucid.svg?style=flat)](https://packagist.org/packages/decodelabs/lucid)
[![GitHub Workflow Status](https://img.shields.io/github/actions/workflow/status/decodelabs/lucid/integrate.yml?branch=develop)](https://github.com/decodelabs/lucid/actions/workflows/integrate.yml)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-44CC11.svg?longCache=true&style=flat)](https://github.com/phpstan/phpstan)
[![License](https://img.shields.io/packagist/l/decodelabs/lucid?style=flat)](https://packagist.org/packages/decodelabs/lucid)

### Flexible and expansive sanitisation and validation framework for PHP

Lucid provides a unified single-value sanitisation and validation structure for making sure your input makes sense.

---


## Installation

Install the library via composer:

```bash
composer require decodelabs/lucid
```

## Usage

Direct value sanitisation can be achieved quickly and painlessly:

```php
use DecodeLabs\Lucid;
$lucid = new Lucid();

// This ensures the value is a string
$myString = $lucid->cast('This is a string', 'string');

// This is nullable
$notAString = $lucid->cast(null, '?string');

// These are constraints - throws an exception
$myString = $lucid->cast('My very long piece of text', 'string', [
    'maxLength' => 10,
    'maxWords' => 4
]);

// Creates an instance of Carbon (DateTime)
$myDate = $lucid->cast('tomorrow', 'date', [
    'min' => 'yesterday',
    'max' => '+3 days'
]);
```

If you need more fine grained control of the responses to constraints, use <code>validate()</code>:

```php
$result = $lucid->validate('potato', 'int', [
    'min' => 4
]);

if(!$result->valid) {
    // Do something with the potato

    foreach($result->errors as $error) {
        echo $error->message;
    }
}
```

Or conversely if you just need a yes or no answer, use <code>is()</code>:

```php
if(!$lucid->is('not a number', 'float')) {
    // do something
}
```

## Custom processors

Lucid uses [Archetype](https://github.com/decodelabs/archetype) to load both <code>Processors</code> and <code>Constraints</code> - implement your own custom classes within <code>DecodeLabs\Lucid\Processor</code> or <code>DecodeLabs\Lucid\Constraint</code> namespaces, or create your own Archetype <code>Resolver</code> to load them from elsewhere.

Please see the selection of existing implementations for details on how to build your own custom classes.


## Provider interfaces

Lucid builds on a sub-package, [Lucid Support](https://github.com/decodelabs/lucid-support) which makes available a set of <code>Provider</code> interfaces to enable embedded implementations of the Sanitizer structure.

Please see the readme in [Lucid Support](https://github.com/decodelabs/lucid-support) for integrating Lucid into your own libraries.


## Licensing
Lucid is licensed under the MIT License. See [LICENSE](./LICENSE) for the full license text.
