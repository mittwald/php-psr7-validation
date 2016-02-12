<?php
namespace Mw\Psr7Validation\Middleware;


use Mw\Psr7Validation\Validator\ValidationResult;
use Mw\Psr7Validation\Validator\ValidatorInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ValidationMiddleware
{



    /**
     * @var ValidatorInterface
     */
    private $validator;



    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }



    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $json   = $request->getParsedBody();
        $result = new ValidationResult();

        $validationResult = $this->validator->validateJson($json, $result);

        if ($validationResult->isSuccessful())
        {
            return $next($request, $response);
        }
        else
        {
            return $response
                ->withStatus(400)
                ->withBody(\GuzzleHttp\Psr7\stream_for(json_encode($validationResult)));
        }
    }

}