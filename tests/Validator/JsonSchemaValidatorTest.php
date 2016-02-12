<?php
namespace Mw\Psr7Validation\Tests\Validator;


use Mw\Psr7Validation\Validator\JsonSchemaValidator;
use Mw\Psr7Validation\Validator\ValidationResult;

class JsonSchemaValidatorTest extends \PHPUnit_Framework_TestCase
{



    public function testInvalidJsonSchemaRaisesError()
    {
        $schema = json_decode('{
            "type": "object",
            "properties": {
                "foo": {"type": "number"}
            }
        }');

        $validator = new JsonSchemaValidator($schema);

        $result = new ValidationResult();
        $validator->validateJson(['foo' => 'Not a number!'], $result);

        $this->assertFalse($result->isSuccessful());
        $this->assertCount(1, $result->getErrorsForProperty('foo'));
    }



    public function testValidJsonSchemaDoesNotRaiseError()
    {
        $schema = json_decode('{
            "type": "object",
            "properties": {
                "foo": {"type": "number"}
            }
        }');

        $validator = new JsonSchemaValidator($schema);

        $result = new ValidationResult();
        $validator->validateJson(['foo' => 12345], $result);

        $this->assertTrue($result->isSuccessful());
        $this->assertCount(0, $result->getErrorsForProperty('foo'));
    }

}