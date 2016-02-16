<?php
namespace Mw\Psr7Validation;

use Flow\JSONPath\JSONPath;
use JsonSchema\RefResolver;
use JsonSchema\Uri\UriRetriever;
use Mw\Psr7Validation\Json\AbsoluteRefResolvingUriRetriever;
use Mw\Psr7Validation\Json\RelativeRefResolver;
use Mw\Psr7Validation\Validator\JsonSchemaValidator;
use Mw\Psr7Validation\Validator\ValidatorInterface;

/**
 * Helper class for quickly building new validators.
 *
 * @package Mw\Psr7Validation
 */
class Factory
{

    /**
     * Builds a JSON schema validator from a JSON schema
     *
     * @param string $uri The JSON schema's URI. May start with `file://` for local files.
     * @return ValidatorInterface The validator
     */
    public static function buildJsonValidatorFromUri($uri)
    {
        $retriever = new UriRetriever();
        $schema = $retriever->retrieve($uri);

        $refResolver = new RefResolver($retriever);
        $refResolver->resolve($schema, $uri);

        return new JsonSchemaValidator($schema);
    }

    /**
     * Builds a JSON schema validator from a Swagger file
     *
     * @param string $swaggerFile The filename of the swagger JSON definition
     * @param string $typeName The type definition (will be looked up in the swagger file at `/definitions/$typeName`.
     * @return ValidatorInterface The validator
     */
    public static function buildJsonValidatorFromSwaggerDefinition($swaggerFile, $typeName)
    {
        $uri = 'file://' . realpath($swaggerFile);

        $retriever = new AbsoluteRefResolvingUriRetriever();
        $schema = $retriever->retrieve($uri);

        $schema = (new JSONPath($schema))->find('$.definitions.' . $typeName)->first()->data();

        $refResolver = new RefResolver($retriever);
        $refResolver->resolve($schema, $uri);

        return new JsonSchemaValidator($schema);
    }

}