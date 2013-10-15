<?php
namespace EchaleGas\Validator;

use \PHPUnit_Framework_TestCase as TestCase;

class ValitronValidatorTest extends TestCase
{
    public function setUp()
    {
        chdir(__DIR__ . '/.././../../../');
    }

    public function testCanValidateLength()
    {
        $rules = [
            'length' => [
                ['name', 1, 100],
            ]
        ];
        $validator = new ValitronValidator($rules);

        $this->assertTrue($validator->isValid(['name' => 'Alejandro']));
    }

    public function testCanValidateInvalidLength()
    {
        $rules = [
            'length' => [
                ['name', 1, 5],
            ]
        ];
        $validator = new ValitronValidator($rules);

        $this->assertFalse($validator->isValid(['name' => 'Alejandro']));
        $errors = $validator->errors();
        $this->assertInternalType('array', $errors);
        $this->assertEquals('Name length must be between 1 and 5', $errors['name'][0]);
    }
}
