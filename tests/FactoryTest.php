<?php
namespace Mw\Psr7Validation\Tests;


use Mw\Psr7Validation\Factory;
use Mw\Psr7Validation\Validator\ValidationResult;

class FactoryTest extends \PHPUnit_Framework_TestCase
{



    public function testValidatorCanBeBuiltFromUri()
    {
        $result = new ValidationResult();

        $validator = Factory::buildJsonValidatorFromUri('file://' . __DIR__ . '/Schemas/test.json');
        $validator->validateJson(['foo' => 123], $result);

        $this->assertTrue($result->isSuccessful());
    }



    public function testValidatorCanBeBuiltFromUri2()
    {
        $result = new ValidationResult();

        $validator = Factory::buildJsonValidatorFromUri('file://' . __DIR__ . '/Schemas/test.json');
        $validator->validateJson(['foo' => 'not a number'], $result);

        $this->assertFalse($result->isSuccessful());
        $this->assertCount(1, $result->getErrorsForProperty('foo'));
    }



    public function testValidatorCanBeBuildFromSwaggerFile()
    {
        $result = new ValidationResult();

        $validator = Factory::buildJsonValidatorFromSwaggerDefinition(__DIR__ . '/Schemas/swagger.json', 'FooType');
        $validator->validateJson(['bar' => ['foo' => 'not a number']], $result);

        $this->assertFalse($result->isSuccessful());
        $this->assertCount(1, $result->getErrorsForProperty('bar.foo'));
    }

}