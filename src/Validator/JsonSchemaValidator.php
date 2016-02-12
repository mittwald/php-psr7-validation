<?php
namespace Mw\Psr7Validation\Validator;



use JsonSchema\Validator;
use stdClass;

class JsonSchemaValidator implements ValidatorInterface
{



    private $validator;


    /** @var stdClass */
    private $schema;



    public function __construct(stdClass $schema, Validator $validator = null)
    {
        if ($validator === null) {
            $validator = new Validator();
        }

        $this->validator = $validator;
        $this->schema    = $schema;
    }

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