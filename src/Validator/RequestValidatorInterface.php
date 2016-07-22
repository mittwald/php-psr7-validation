<?php
namespace Mw\Psr7Validation\Validator;


use Psr\Http\Message\ServerRequestInterface;

interface RequestValidatorInterface extends ValidatorInterface
{

    /**
     * Validates a JSON object
     *
     * @param ServerRequestInterface $request The request to validate
     * @param ValidationResult       $result  The result object in which to store validation result
     * @return
     */
    public function validateRequest(ServerRequestInterface $request, ValidationResult $result);

}