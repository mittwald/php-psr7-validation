# PSR-7 validation middlewares

## Synposis

This package contains a [PSR-7][psr7] middleware for validating HTTP requests,
especially using JSON schema validation.

## License

This package is [MIT-licensed](LICENSE.txt).

## Examples

Validating request bodies using a JSON schema (using the [Slim framework][slim]):

```php
$app->post('/customers', $handler)
    ->add(new ValidationMiddleware(
        Factory::buildJsonValidatorFromUri('path/to/json-schema.json')
    ));
```

Validating request bodies using a [Swagger specification file][swag]:

```php
$app->post('/customers', $handler)
    ->add(new ValidationMiddleware(
        Factory::buildJsonValidatorFromSwaggerDefinition('path/to/swagger.json', 'MyType')
    ));
```

Validating request bodies using a custom validator (using PHP 7's anonymous classes, for no other reason because I can):

```php
$app->post('/customers', $handler)
    ->add(new ValidationMiddleware(
        new class implements ValidatorInterface {
            public function validateJson($jsonDocument, ValidationResult $result) {
                $result->addErrorForProperty('customernumber', 'Foo');
            }
        }
    ));
```

Combining multiple validators:

```php
$app->post('/customers', $handler)
    ->add(new ValidationMiddleware(
        new CombinedValidator(
            Factory::buildJsonValidatorFromUri('path/to/schema.json'),
            new MyVerySpecialCustomValidator()
        )
    ));
```



[slim]: http://www.slimframework.com/
[swag]: http://swagger.io/specification/
[psr7]: http://www.php-fig.org/psr/psr-7/
