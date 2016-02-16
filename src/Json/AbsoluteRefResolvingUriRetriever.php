<?php
namespace Mw\Psr7Validation\Json;

use JsonSchema\Uri\UriRetriever;

/**
 * Subclass of the UriRetriever class for resolving relative references to absolute ones.
 *
 * @package Mw\Psr7Validation
 * @subpackage Json
 */
class AbsoluteRefResolvingUriRetriever extends UriRetriever
{

    /**
     * {@inheritdoc}
     */
    public function retrieve($uri, $baseUri = NULL)
    {
        $schema = parent::retrieve($uri, $baseUri);

        $swg = new RelativeRefResolver($uri);
        $swg->resolve($schema);

        return $schema;
    }

}