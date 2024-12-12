<?php

use PHPUnit\Framework\TestCase;

final class ValidateOptionsTest extends TestCase
{
    public function testDelive(): void
    {

        $this->expectException(\InvalidArgumentException::class);
        $options = ['optionA' => 'A', 'optionB' => 'B', 'optionC'=> 'C', 'optionD' => 'D'];
        $required_options = ['optionA', 'option6'];

        \Mdpbriar\ForemApiPhpClient\ValidateOptions::validateArrayFields($options, $required_options);
    }

    public function testValidationPass(): void
    {
        $this->expectNotToPerformAssertions();
        $options = ['optionA' => 'A', 'optionB' => 'B', 'optionC'=> 'C', 'optionD' => 'D'];
        $required_options = ['optionA', 'optionC'];

        \Mdpbriar\ForemApiPhpClient\ValidateOptions::validateArrayFields($options, $required_options);

    }


}