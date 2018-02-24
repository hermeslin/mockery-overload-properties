<?php
namespace Mop\UnitTest;

use Mop\InstancePropertyMocker as mop;
use PHPUnit\Framework\TestCase;

class InstancePropertyTest extends TestCase
{
    public function tearDown()
    {
        mop::close();
    }

    /**
     * @test
     */
    public function instancePropertyShouldCorrect()
    {
        $properties = [
            'A' => '1',
            'B' => 2,
            'C' => false,
            'D' => ['1', 2, false]
        ];

        mop::mock('TestInstance', $properties);

        // construct TestInstance
        $testInstance = new \TestInstance;

        $this->assertEquals('1', $testInstance->A);
        $this->assertEquals(2, $testInstance->B);
        $this->assertEquals(false, $testInstance->C);
        $this->assertEquals(['1', 2, false], $testInstance->D);
    }
}