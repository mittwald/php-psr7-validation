<?php
namespace Mw\Psr7Validation\Validator;

/**
 * Interface definition for validators
 *
 * @package    Mw\Psr7Validation
 * @subpackage Validator
 */
interface ValidatorInterface
{

    /**
     * Validates a JSON object
     *
     * @param array            $jsonDocument The JSON document to validate
     * @param ValidationResult $result       The result object in which to store validation result
     */
    public function validateJson($jsonDocument, ValidationResult $result);

}