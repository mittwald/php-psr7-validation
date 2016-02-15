<?php
namespace Mw\Psr7Validation\Middleware;

use Mw\Psr7Validation\Validator\ValidationResult;
use Mw\Psr7Validation\Validator\ValidatorInterface;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * PSR-7 middleware for validating HTTP requests
 *
 * @package    Mw\Psr7Validation
 * @subpackage Middleware
 */
class ValidationMiddleware
{

    /** @var ValidatorInterface */
    private $validator;

    /** @var int */
    private $responseCode;

    /**
     * ValidationMiddleware constructor.
     *
     * @param ValidatorInterface $validator    The validator to use for validating request bodies
     * @param int                $responseCode The response code to use when validation failed
     */
    public function __construct(ValidatorInterface $validator, $responseCode = 400)
    {
        $this->validator = $validator;
        $this->responseCode = $responseCode;
    }

    /**
     * The actual middleware function. Invokes the validator and passes the
     * request to the next middleware if validation was successful.
     *
     * @param ServerRequestInterface $request  The incoming request
     * @param ResponseInterface      $response The HTTP response
     * @param callable               $next     The next middleware
     * @return MessageInterface The HTTP response
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $json = $request->getParsedBody();
        $result = new ValidationResult();

        $validationResult = $this->validator->validateJson($json, $result);

        if ($validationResult->isSuccessful()) {
            return $next($request, $response);
        } else {
            return $response
                ->withStatus($this->responseCode)
                ->withBody(\GuzzleHttp\Psr7\stream_for(json_encode($validationResult)));
        }
    }

}