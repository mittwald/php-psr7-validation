<?php
namespace Mw\Psr7Validation\Validator;

/**
 * Validator aggregator that executes multiple validators
 *
 * @package    Mw\Psr7Validation
 * @subpackage Validator
 */
class CombinedValidator implements ValidatorInterface
{

    /** @var ValidatorInterface[] */
    private $validatorInterfaces;

    /**
     * CombinedValidator constructor.
     *
     * @param ValidatorInterface[] ...$validatorInterfaces Validators to combine in this one
     */
    public function __construct(ValidatorInterface ...$validatorInterfaces)
    {
        $this->validatorInterfaces = $validatorInterfaces;
    }

    /**
     * Validates a JSON object
     *
     * @param array            $jsonDocument The JSON document to validate
     * @param ValidationResult $result       The result object in which to store validation result
     */
    public function validateJson($jsonDocument, ValidationResult $result)
    {
        foreach ($this->validatorInterfaces as $validator) {
            $validator->validateJson($jsonDocument, $result);
        }
    }
}