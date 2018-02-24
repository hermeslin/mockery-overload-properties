<?php
namespace Mop\UnitTest;

use PHPUnit\Framework\TestCase;
use Mockery;
use Vip;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class LegacyCodeFailTest extends TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * @test
     */
    public function userBonusShouldCorrectA()
    {
        // how to test this ?
        // insert one data into your test db ?
        $vip = new Vip;
        $this->assertEquals(200, $vip->bonus($userId = 1));
    }

    /**
     * @test
     */
    public function userBonusShouldCorrectB()
    {
        // or use mockery to overload User instance
        // see: http://docs.mockery.io/en/latest/cookbook/mocking_hard_dependencies.html
        $user = Mockery::mock('overload:\User');

        // but your legacy code use proterties to store user data from database,
        // how to mock User instance's properties ?
        $user->id = 1;
        $user->isVip = true;
        $user->rank = 2;

        // this assert will be fail, although we success mock User instance
        // because we can't mock User instance's properties via overload keyword
        $vip = new Vip;
        $this->assertEquals(200, $vip->bonus($userId = 1));
    }
}