<?php
namespace Mw\Psr7Validation\Validator;



interface ValidatorInterface
{



    /**
     * @param array            $jsonDocument
     * @param ValidationResult $result
     * @return ValidationResult
     */
    public function validateJson($jsonDocument, ValidationResult $result);

}