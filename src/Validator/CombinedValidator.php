<?php
namespace Mw\Psr7Validation\Validator;



class CombinedValidator implements ValidatorInterface
{



    /**
     * @var ValidatorInterface[]
     */
    private $validatorInterfaces;



    public function __construct(ValidatorInterface ...$validatorInterfaces)
    {
        $this->validatorInterfaces = $validatorInterfaces;
    }



    /**
     * @param array            $jsonDocument
     * @param ValidationResult $result
     * @return ValidationResult
     */
    public function validateJson($jsonDocument, ValidationResult $result)
    {
        foreach ($this->validatorInterfaces as $validator)
        {
            $validator->validateJson($jsonDocument, $result);
        }
    }
}