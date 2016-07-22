<?php
namespace Mw\Psr7Validation\Validator;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface definition for request validators.
 *
 * Request validators are passed the actual HTTP request and can use that in
 * their validation logic.
 *
 * @package    Mw\Psr7Validation
 * @subpackage Validator
 */
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
