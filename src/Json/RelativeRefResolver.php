<?php
namespace Mw\Psr7Validation\Json;

/**
 * Helper class for resolving references in JSON objects
 *
 * This class converts local references in JSON objects to absolute references
 * using a filename. This is necessary to work around some limitations of the
 * `JsonSchema\RefResolver` class.
 *
 * @package Mw\Psr7Validation
 * @subpackage Json
 */
class RelativeRefResolver
{

    private $filename;

    /**
     * The filename to use when converting relative references to absolute
     *
     * @param string $filename The base filename
     */
    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Converts relative references to absolute ones in a JSON object
     *
     * @param \stdClass $schema
     * @return void
     */
    public function resolve($schema)
    {
        $ref = '$ref';
        if (is_object($schema)) {
            if (isset($schema->$ref)) {
                list($file, $path) = explode('#', $schema->$ref);
                if (!$file) {
                    $schema->$ref = $this->filename . '#' . $path;
                }
            }

            foreach (get_object_vars($schema) as $var) {
                $this->resolve($var);
            }
        } else if (is_array($schema)) {
            foreach ($schema as $var) {
                $this->resolve($var);
            }
        }
    }

}