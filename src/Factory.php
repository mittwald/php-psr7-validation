<?php
namespace Mw\Psr7Validation;


use JsonSchema\RefResolver;
use JsonSchema\Uri\UriRetriever;
use Mw\Psr7Validation\Validator\JsonSchemaValidator;

class Factory
{



    public static function buildJsonValidatorFromUri($uri)
    {
        $retriever = new UriRetriever();
        $schema = $retriever->retrieve($uri);

        $refResolver = new RefResolver($retriever);
        $refResolver->resolve($schema, $uri);

        return new JsonSchemaValidator($schema);
    }

}