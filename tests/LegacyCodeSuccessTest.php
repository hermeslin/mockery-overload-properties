<?php
namespace Mop\UnitTest;

use PHPUnit\Framework\TestCase;
use Mop\InstancePropertyMocker as mop;
use Vip;

/**
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class LegacyCodeSuccessTest extends TestCase
{
    public function tearDown()
    {
        // when teardown, dont forget close mockery
        mop::close();
    }

    /**
     * @test
     */
    public function vipUserBonusShouldCorrect()
    {
        $user = mop::mock(
            '\User', $properties = [
            'id' => 1,
            'isVip' => true,
            'rank' => 3
            ]
        );

        // bounus should 355
        $bunus = 100 * 3 + 55;

        // this assert will be success,
        // because we mock User instance's properties
        $vip = new Vip;
        $this->assertEquals($bunus, $vip->bonus($userId = 1));
    }

    /**
     * @test
     */
    public function notVipUserBonusShouldCorrect()
    {
        $user = mop::mock(
            '\User', $properties = [
            'id' => 2,
            'isVip' => false,
            'rank' => 99
            ]
        );

        // bounus should be 149
        $bunus = 100 * 0.5 + 99;

        $vip = new Vip;
        $this->assertEquals($bunus, $vip->bonus($userId = 2));
    }
}