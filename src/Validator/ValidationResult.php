<?php
namespace Mw\Psr7Validation\Validator;


use JsonSerializable;


class ValidationResult implements JsonSerializable
{



    private $errors = [];



    public function isSuccessful()
    {
        return count($this->errors) === 0;
    }



    public function addErrorForProperty($property, $error)
    {
        if (!isset($this->errors[$property]))
        {
            $this->errors[$property] = [];
        }
        $this->errors[$property][] = $error;
    }



    public function getErrorsForProperty($property)
    {
        if (isset($this->errors[$property])) {
            return $this->errors[$property];
        }
        return [];
    }



    public function jsonSerialize()
    {
        return $this->errors;
    }
}