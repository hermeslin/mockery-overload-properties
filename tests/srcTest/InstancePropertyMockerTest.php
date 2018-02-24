<?php
namespace Mop\UnitTest;

use Mop\InstancePropertyMocker as mop;
use PHPUnit\Framework\TestCase;

class InstancePropertyMockerTest extends TestCase
{
    public function tearDown()
    {
        mop::close();
    }

    /**
     * @test
     */
    public function mopMockShouldReturnMockeryInterface()
    {
        $mock = mop::mock('SomeInstance');
        $this->assertInstanceOf('Mockery\MockInterface', $mock);
    }

    /**
     * @test
     */
    public function mopSetPropertiesShouldCorrect()
    {
        $properties = [
            'A' => 'a',
            'B' => 'b'
        ];

        $result = mop::property($properties, 'SomeInstance');
        $this->assertTrue($result);

        // and file should exists
        $tmpFolder = mop::$tmpFolder;
        $tmpFile = dirname(dirname(dirname(__FILE__))) . '/src/' . $tmpFolder  . '/someinstance';
        $this->assertFileExists($tmpFile);

        // and file should contain json
        $result = file_get_contents($tmpFile);
        $this->assertEquals(json_encode($properties), $result);
    }

    /**
     * @test
     */
    public function mopCloseShouldDeleteFile()
    {
        $tmpFolder = dirname(dirname(dirname(__FILE__))) . '/src/' . mop::$tmpFolder;

        $properties = [
            'A' => 'a',
            'B' => 'b'
        ];

        mop::property($properties, 'SomeInstanceA');
        mop::close('SomeInstanceA');

        //
        $this->assertFalse(file_exists("{$tmpFolder}/someinstancea"));

        //
        mop::property($properties, 'SomeInstanceB');
        mop::property($properties, 'SomeInstanceC');
        mop::close();

        $this->assertFalse(file_exists("{$tmpFolder}/someinstanceb"));
        $this->assertFalse(file_exists("{$tmpFolder}/someinstancec"));
    }
}
