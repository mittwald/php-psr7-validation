<?php
namespace Mw\Psr7Validation\Validator;

use JsonSerializable;

/**
 * Helper class modeling a validation result
 *
 * @package    Mw\Psr7Validation
 * @subpackage Validator
 */
class ValidationResult implements JsonSerializable
{

    private $errors = [];

    /**
     * Tests if the validation was successful
     *
     * @return bool TRUE if the validation was successful, otherwise FALSE
     */
    public function isSuccessful()
    {
        return count($this->errors) === 0;
    }

    /**
     * Registers a new error for a property
     *
     * @param string $property The property name
     * @param string $error    The error
     * @return void
     */
    public function addErrorForProperty($property, $error)
    {
        if (!isset($this->errors[$property])) {
            $this->errors[$property] = [];
        }
        $this->errors[$property][] = $error;
    }

    /**
     * Gets all registered errors for a property
     *
     * @param string $property The property name
     * @return array All errors for this property
     */
    public function getErrorsForProperty($property)
    {
        if (isset($this->errors[$property])) {
            return $this->errors[$property];
        }
        return [];
    }

    /**
     * Serializes this validation result into a JSON object
     *
     * @return array The JSON object
     */
    public function jsonSerialize()
    {
        return $this->errors;
    }
}