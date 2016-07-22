<?php
namespace Mw\Psr7Validation\Validator;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Validator aggregator that executes multiple validators
 *
 * @package    Mw\Psr7Validation
 * @subpackage Validator
 */
class CombinedValidator implements RequestValidatorInterface
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
     * Validates the HTTP request itself
     *
     * @param ServerRequestInterface $request The HTTP request
     * @param ValidationResult       $result  The result object in which to store validation results
     */
    public function validateRequest(ServerRequestInterface $request, ValidationResult $result)
    {
        foreach ($this->validatorInterfaces as $validator) {
            if ($validator instanceof RequestValidatorInterface) {
                $validator->validateRequest($request, $result);
            }
        }
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