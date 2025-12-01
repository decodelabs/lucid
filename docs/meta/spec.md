# Lucid — Package Specification

> **Cluster:** `logic`
> **Language:** `php`
> **Milestone:** `m2`
> **Repo:** `https://github.com/decodelabs/lucid`
> **Role:** Value sanitisation

## Overview

### Purpose

Lucid provides a flexible and expansive sanitization and validation framework for PHP. It enables type-safe value coercion, sanitization, and validation with a unified API. Lucid supports:

- Type coercion and sanitization via processors
- Validation with constraints
- Error reporting and validation results
- Extensible processor and constraint system
- Provider interfaces for embedding in other classes
- Support for nullable types, arrays, and instances
- Integration with Archetype for automatic processor/constraint discovery

Lucid is designed to provide a clean, type-safe way to handle input validation and sanitization throughout PHP applications, with support for custom processors and constraints.

### Non-Goals

- Lucid does not provide form validation or field-level validation (handled by higher-level packages)
- It does not provide database validation or ORM integration
- It does not handle file upload validation
- It does not provide schema validation (JSON Schema, XML Schema, etc.)
- It does not handle complex nested object validation beyond arrays
- It does not provide validation rule builders or fluent interfaces

## Role in the Ecosystem

### Cluster & Positioning

Lucid belongs to the **logic** cluster, providing value sanitization and validation capabilities. It sits alongside other logic packages and is used throughout the ecosystem for input validation, type coercion, and data sanitization.

### Usage Contexts

Lucid is used for:

- Input validation in forms and APIs
- Type coercion and sanitization
- Data transformation and normalization
- Configuration validation
- User input sanitization
- Data model validation
- Parameter validation in services

## Public Surface

### Key Types

- **`Lucid`** — Main class implementing `DirectContext` and `Service`. Provides static `loadProcessor()` method and instance methods for casting, validation, and type checking.

- **`Lucid\Processor`** — Interface for type processors. Handles value preparation, coercion, alteration, and validation.

- **`Lucid\ProcessorTrait`** — Trait providing default processor implementation including constraint management and validation.

- **`Lucid\Constraint`** — Interface for validation constraints. Handles value preparation, alteration, and validation with parameter support.

- **`Lucid\ConstraintTrait`** — Trait providing default constraint implementation.

- **`Lucid\Provider`** — Marker interface for classes that provide Lucid functionality.

- **`Lucid\ProviderTrait`** — Trait providing helper methods for casting and validation.

- **`Lucid\Provider\DirectContext`** — Interface for direct value casting and validation.

- **`Lucid\Provider\DirectContextTrait`** — Trait implementing `DirectContext` interface.

- **`Lucid\Provider\SingleContext`** — Interface for single-value context casting and validation.

- **`Lucid\Provider\SingleContextTrait`** — Trait implementing `SingleContext` interface.

- **`Lucid\Provider\MultiContext`** — Interface for multi-value context casting and validation.

- **`Lucid\Provider\MixedContext`** — Interface extending `SingleContext` for mixed value contexts.

- **`Lucid\Validate\Result`** — Class representing validation result with value, errors, and validity status.

- **`Lucid\Validate\Error`** — Class representing a validation error with message, constraint, and parameters.

- **`Lucid\Processor\StringNative`** — Processor for string type coercion.

- **`Lucid\Processor\IntNative`** — Processor for integer type coercion.

- **`Lucid\Processor\FloatNative`** — Processor for float type coercion.

- **`Lucid\Processor\BoolNative`** — Processor for boolean type coercion.

- **`Lucid\Processor\ArrayNative`** — Processor for array type coercion with child type support.

- **`Lucid\Processor\Email`** — Processor for email validation and coercion.

- **`Lucid\Processor\Url`** — Processor for URL validation and coercion.

- **`Lucid\Processor\Json`** — Processor for JSON validation and coercion.

- **`Lucid\Constraint\Required`** — Constraint for required value validation.

- **`Lucid\Constraint\DefaultValue`** — Constraint for providing default values.

- **`Lucid\Constraint\Number\Min`** — Constraint for minimum numeric value validation.

- **`Lucid\Constraint\Number\Max`** — Constraint for maximum numeric value validation.

- **`Lucid\Constraint\Number\Range`** — Constraint for numeric range validation.

- **`Lucid\Constraint\String\MinLength`** — Constraint for minimum string length validation.

- **`Lucid\Constraint\String\MaxLength`** — Constraint for maximum string length validation.

- **`Lucid\Constraint\String\MinWords`** — Constraint for minimum word count validation.

- **`Lucid\Constraint\String\MaxWords`** — Constraint for maximum word count validation.

- **`Lucid\Constraint\String\Pattern`** — Constraint for regex pattern validation.

- **`Lucid\Constraint\String\Trim`** — Constraint for string trimming.

- **`Lucid\Constraint\String\Emojis`** — Constraint for emoji handling.

- **`Lucid\Constraint\Array\In`** — Constraint for array membership validation.

- **`Lucid\Constraint\In`** — Constraint for value membership validation.

- **`Lucid\Constraint\Sanitize`** — Constraint for value sanitization.

- **`Lucid\Constraint\Validate`** — Constraint for custom validation.

- **`Lucid\Constraint\Processor`** — Constraint wrapper for processor-level errors.

### Main Entry Points

- **`Lucid::loadProcessor(string $type, array|Closure|null $setup): Processor`** — Static method for loading a processor by type name. Handles nullable types (`?type`), arrays (`type[]` or `array<type>`), and instances (`:Type`).

- **`Lucid::cast(mixed $value, string $type, array|Closure|null $setup): mixed`** — Casts a value to the specified type with constraints. Throws exception on validation failure.

- **`Lucid::validate(mixed $value, string $type, array|Closure|null $setup): Result`** — Validates a value against the specified type and constraints. Returns result with errors.

- **`Lucid::is(mixed $value, string $type, array|Closure|null $setup): bool`** — Checks if a value is valid for the specified type and constraints. Returns boolean.

- **`Processor::coerce(mixed $value): mixed`** — Coerces a value to the processor's output type.

- **`Processor::prepareValue(mixed $value): mixed`** — Prepares a value by applying constraint preparation.

- **`Processor::alterValue(mixed $value): mixed`** — Alters a value by applying constraint alteration.

- **`Processor::test(string $constraint, mixed $param): static`** — Adds a constraint to the processor.

- **`Processor::validate(mixed $value): Generator<Error|null>`** — Validates a value and yields errors.

- **`Processor::validateType(mixed $value): Generator<Error|null>`** — Validates value type compatibility.

- **`Constraint::validate(mixed $value): Generator<Error|null>`** — Validates a value against the constraint.

- **`Constraint::prepareValue(mixed $value): mixed`** — Prepares a value before coercion.

- **`Constraint::alterValue(mixed $value): mixed`** — Alters a value after coercion.

- **`Result::valid: bool`** — Property indicating if validation passed.

- **`Result::value: mixed`** — Property containing the validated value.

- **`Result::errors: array<string,Error>`** — Property containing validation errors.

- **`Error::message: string`** — Property containing the formatted error message.

- **`Error::value: mixed`** — Property containing the value that failed validation.

## Dependencies

### Decode Labs

- **`coercion`** — Used for type coercion when converting values between types.

- **`exceptional`** — Used for exception handling throughout the package.

- **`kingdom`** — Used for service container integration via `Service` interface.

- **`slingshot`** — Used for dependency injection when instantiating processors and constraints.

### External

- None (pure PHP implementation)

### Optional Dependencies

- **`compass`** — Detected at runtime if installed, used for IP address validation support.

- **`dictum`** — Detected at runtime if installed, used for text formatting support.

- **`guidance`** — Detected at runtime if installed, used for UID validation support.

- **`kairos`** — Detected at runtime if installed, used for date and time validation support.

- **`spectrum`** — Detected at runtime if installed, used for color validation support.

## Behaviour & Contracts

### Invariants

- Processors are loaded via Archetype using Slingshot for dependency injection
- Constraints are sorted by weight before validation
- Validation stops early if a constraint returns false
- Null values are handled separately from type validation
- Empty strings are converted to null for required validation
- Processors support nullable types via `?type` syntax
- Processors support arrays via `type[]` or `array<type>` syntax
- Processors support instances via `:Type` syntax
- Constraints validate parameter types before use
- Error messages support parameter substitution via `%key%` syntax

### Input & Output Contracts

- **`Lucid::loadProcessor(string $type, array|Closure|null $setup): Processor`** — Loads a processor by type name. Handles type modifiers (`?`, `[]`, `:`, `array<>`). Returns configured processor instance.

- **`Lucid::cast(mixed $value, string $type, array|Closure|null $setup): mixed`** — Casts value to type. Returns coerced value. Throws `UnexpectedValue` on validation failure.

- **`Lucid::validate(mixed $value, string $type, array|Closure|null $setup): Result`** — Validates value. Returns result with value and errors. Never throws exceptions.

- **`Lucid::is(mixed $value, string $type, array|Closure|null $setup): bool`** — Checks value validity. Returns true if valid, false otherwise. May throw `Constraint\NotFound` for missing constraints.

- **`Processor::coerce(mixed $value): mixed`** — Coerces value to output type. Returns coerced value or null. Throws exception on coercion failure.

- **`Processor::prepareValue(mixed $value): mixed`** — Prepares value by applying constraint preparation. Returns prepared value.

- **`Processor::alterValue(mixed $value): mixed`** — Alters value by applying constraint alteration. Returns altered value or null if alteration fails.

- **`Processor::test(string $constraint, mixed $param): static`** — Adds constraint to processor. Returns self for method chaining. Throws `Constraint\NotFound` if constraint not found.

- **`Processor::validate(mixed $value): Generator<Error|null>`** — Validates value. Yields errors or null. Returns true if valid, false otherwise.

- **`Constraint::validate(mixed $value): Generator<Error|null>`** — Validates value against constraint. Yields errors or null. Returns true if valid, false otherwise.

- **`Constraint::prepareValue(mixed $value): mixed`** — Prepares value before coercion. Returns prepared value.

- **`Constraint::alterValue(mixed $value): mixed`** — Alters value after coercion. Returns altered value or null.

- **`Result::valid: bool`** — Returns true if no errors, false otherwise.

- **`Result::value: mixed`** — Returns the validated value (may be null).

- **`Result::errors: array<string,Error>`** — Returns array of validation errors keyed by error ID.

- **`Error::message: string`** — Returns formatted error message with parameter substitution.

- **`Error::value: mixed`** — Returns the value that failed validation.

## Error Handling

Lucid uses the Exceptional pattern for error handling. Key exception types:

- **`UnexpectedValue`** — Thrown when value cannot be coerced to target type or validation fails during `cast()`.

- **`Constraint\NotFound`** — Thrown when a constraint cannot be found for a processor type.

- **`InvalidArgument`** — Thrown when constraint parameters are invalid.

Exceptions preserve the original service context and include detailed error messages. Validation errors are collected in `Result` objects rather than thrown as exceptions.

## Configuration & Extensibility

### Extension Points

- **Custom Processors** — Implement `Processor` interface in `DecodeLabs\Lucid\Processor` namespace or provide custom Archetype resolver.

- **Custom Constraints** — Implement `Constraint` interface in `DecodeLabs\Lucid\Constraint` namespace or processor-specific namespace.

- **Provider Interfaces** — Implement `DirectContext`, `SingleContext`, `MultiContext`, or `MixedContext` to embed Lucid functionality in other classes.

- **Custom Archetype Resolvers** — Provide custom Archetype resolvers to load processors and constraints from alternative locations.

### Configuration

- **Processor Loading** — Processors are loaded via Archetype using Slingshot. Type names are resolved to processor class names.

- **Constraint Loading** — Constraints are loaded dynamically based on processor name and output types. Supports processor-specific and generic constraints.

- **Type Modifiers** — Type strings support modifiers: `?` (nullable), `[]` (array), `array<>` (typed array), `:` (instance).

- **Constraint Setup** — Constraints can be configured via array or closure. Closure receives processor instance for configuration.

- **Default Constraints** — Processors can define default constraints via `getDefaultConstraints()` method.

- **Constraint Weight** — Constraints are sorted by weight before validation. Lower weights are validated first.

## Interactions with Other Packages

- **Archetype** — Used for automatic processor and constraint discovery and loading.

- **Slingshot** — Used for dependency injection when instantiating processors and constraints.

- **Coercion** — Used for type coercion when converting values between types.

- **Exceptional** — Used for exception handling throughout the package.

- **Kingdom** — Used for service container integration via `Service` interface.

- **Compass** — Optional integration for IP address validation support.

- **Dictum** — Optional integration for text formatting support.

- **Guidance** — Optional integration for UID validation support.

- **Kairos** — Optional integration for date and time validation support.

- **Spectrum** — Optional integration for color validation support.

## Usage Examples

### Basic Casting

```php
use DecodeLabs\Lucid;

$lucid = new Lucid();

// Cast to string
$myString = $lucid->cast('This is a string', 'string');

// Nullable type
$notAString = $lucid->cast(null, '?string');

// With constraints
$myString = $lucid->cast('My very long piece of text', 'string', [
    'maxLength' => 10,
    'maxWords' => 4
]);

// Date with constraints
$myDate = $lucid->cast('tomorrow', 'date', [
    'min' => 'yesterday',
    'max' => '+3 days'
]);
```

### Validation

```php
use DecodeLabs\Lucid;

$lucid = new Lucid();

// Validate with error collection
$result = $lucid->validate('potato', 'int', [
    'min' => 4
]);

if (!$result->valid) {
    foreach ($result->errors as $error) {
        echo $error->message;
    }
}

// Simple boolean check
if (!$lucid->is('not a number', 'float')) {
    // Handle invalid value
}
```

### Type Modifiers

```php
use DecodeLabs\Lucid;

$lucid = new Lucid();

// Nullable type
$value = $lucid->cast(null, '?string');

// Array type
$values = $lucid->cast([1, 2, 3], 'int[]');

// Typed array
$values = $lucid->cast([1, 2, 3], 'array<int>');

// Instance type
$instance = $lucid->cast($object, ':MyClass');
```

### Custom Processor

```php
use DecodeLabs\Lucid\Processor;
use DecodeLabs\Lucid\ProcessorTrait;

class MyProcessor implements Processor
{
    use ProcessorTrait;

    public const array OutputTypes = ['mytype'];

    public function coerce(mixed $value): ?MyType
    {
        if ($value === null) {
            return null;
        }

        return new MyType($value);
    }
}
```

### Custom Constraint

```php
use DecodeLabs\Lucid\Constraint;
use DecodeLabs\Lucid\ConstraintTrait;
use DecodeLabs\Lucid\Constraint\NameTrait;
use DecodeLabs\Lucid\Validate\Error;
use Generator;

class MyConstraint implements Constraint
{
    use ConstraintTrait;
    use NameTrait;

    public const int Weight = 20;
    public const array OutputTypes = ['string'];

    public function validate(mixed $value): Generator
    {
        if (!$this->isValid($value)) {
            yield new Error(
                $this,
                $value,
                '%type% value is invalid'
            );
        }

        return true;
    }
}
```

### Provider Interface

```php
use DecodeLabs\Lucid\Provider\SingleContext;
use DecodeLabs\Lucid\Provider\SingleContextTrait;

class MyValue implements SingleContext
{
    use SingleContextTrait;

    public function __construct(
        protected mixed $value
    ) {
    }

    protected function getValue(): mixed
    {
        return $this->value;
    }
}

$value = new MyValue('123');
$int = $value->as('int');
$result = $value->validate('int', ['min' => 0]);
$isValid = $value->is('int');
```

### Constraint Setup

```php
use DecodeLabs\Lucid;

$lucid = new Lucid();

// Array setup
$value = $lucid->cast('text', 'string', [
    'maxLength' => 10,
    'trim' => true
]);

// Closure setup
$value = $lucid->cast('text', 'string', function($processor) {
    $processor->test('maxLength', 10);
    $processor->test('trim', true);
});
```

## Implementation Notes (for Contributors)

### Architecture

- **Processor System** — Processors handle type coercion, value preparation, alteration, and validation. They use constraints for validation rules.

- **Constraint System** — Constraints validate values and can prepare or alter values. They are sorted by weight before validation.

- **Type Resolution** — Type strings are parsed to extract modifiers (`?`, `[]`, `:`, `array<>`) and resolved to processor class names via Archetype.

- **Validation Flow** — Validation follows: prepare value → coerce → alter → validate type → validate constraints. Stops early if validation fails.

- **Error Collection** — Errors are collected in `Result` objects rather than thrown as exceptions, allowing multiple errors to be reported.

- **Provider Interfaces** — Provider interfaces allow embedding Lucid functionality in other classes via traits.

- **Archetype Integration** — Processors and constraints are loaded via Archetype, allowing automatic discovery and custom resolvers.

- **Slingshot Integration** — Processors and constraints are instantiated via Slingshot, allowing dependency injection.

### Performance Considerations

- Processors and constraints are instantiated on demand
- Constraints are sorted once during preparation
- Validation uses generators for efficient error collection
- Type resolution is cached by Archetype

### Design Decisions

- **Generator-Based Validation** — Using generators allows efficient error collection and early termination.

- **Provider Interfaces** — Providing multiple provider interfaces allows flexible integration patterns.

- **Type Modifiers** — Supporting type modifiers in type strings provides a concise API for common patterns.

- **Constraint Weight** — Using weight for constraint ordering provides predictable validation order.

- **Error Collection** — Collecting errors in results rather than throwing exceptions allows multiple errors to be reported.

- **Archetype Integration** — Using Archetype for processor/constraint discovery provides extensibility without configuration.

- **Trait-Based Implementation** — Providing traits for common implementations reduces boilerplate while allowing customization.

## Testing & Quality

**Code Quality:** 4.5/5 — Excellent, mature codebase with comprehensive functionality, type safety, and extensibility.

**README Quality:** 3/5 — Good documentation with clear usage examples covering main use cases.

**Documentation:** 0/5 — No formal documentation beyond README.

**Tests:** 0/5 — No test suite currently.

See `composer.json` for supported PHP versions.

## Roadmap & Future Ideas

- Enhanced documentation and API reference
- Test suite implementation
- Additional built-in processors and constraints
- Performance optimizations
- Schema validation support
- Complex nested object validation
- Validation rule builders
- Fluent interface support
- Additional provider interfaces

## References

- [Decode Labs Chorus](https://github.com/decodelabs/chorus)
- [Lucid Repository](https://github.com/decodelabs/lucid)
- [Lucid Support Repository](https://github.com/decodelabs/lucid-support)

