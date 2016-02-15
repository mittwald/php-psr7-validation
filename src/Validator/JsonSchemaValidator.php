<?php
namespace Mw\Psr7Validation\Validator;

use JsonSchema\Validator;
use stdClass;

/**
 * Validator that uses a JSON schema for validation requests
 *
 * @package    Mw\Psr7Validation
 * @subpackage Validator
 */
class JsonSchemaValidator implements ValidatorInterface
{

    /** @var Validator */
    private $validator;

    /** @var stdClass */
    private $schema;

    /**
     * JsonSchemaValidator constructor.
     *
     * @param stdClass  $schema    The JSON schema
     * @param Validator $validator The (internal) JSON schema validator
     */
    public function __construct(stdClass $schema, Validator $validator = null)
    {
        if ($validator === null) {
            $validator = new Validator();
        }

        $this->validator = $validator;
        $this->schema = $schema;
    }

    /**
     * Validates a JSON object
     *
     * @param array            $jsonDocument The JSON document to validate
     * @param ValidationResult $result       The result object in which to store validation result
     */
    public function validateJson($jsonDocument, ValidationResult $result)
    {
        if (!$jsonDocument instanceof stdClass) {
            $jsonDocument = json_decode(json_encode($jsonDocument));
        }

        $this->validator->check($jsonDocument, $this->schema);
        if (!$this->validator->isValid()) {
            foreach ($this->validator->getErrors() as $error) {
                $result->addErrorForProperty($error['property'], $error['message']);
            }
        }
    }

}