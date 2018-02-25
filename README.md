# mockery overload properties
mock instance's properties via Mockery's overload keyword

## installation
use composer to install `mockery-overload-properties`

```ssh
$ composer require --dev hermeslin/mockery-overload-properties
```

## test legacy sample code
under the `example` folder, you can see the sample code taht we want to test:
1. User.php
2. Vip.php

and you'll find the hard dependencies in `Vip.php`.

hard dependencies are not a big deal, you can use [Mockery's `overload` keyword](http://docs.mockery.io/en/latest/cookbook/mocking_hard_dependencies.html) to mock `User` instance easily, but it difficult to mock `User` instance properties when `User`  set the properties on its `__construct` phase.

## test case
under the `tests` folder, there are two test cases here:
1. LegacyCodeFailTest.php
2. LegacyCodeSuccessTest.php

see `tests\LegacyCodeSuccessTest.php` will show you how to use `mockery-overload-properties` to mock `User`
```php
    /**
     * @test
     */
    public function notVipUserBonusShouldCorrect()
    {
        $properties = [
            'id' => 2,
            'isVip' => false,
            'rank' => 99
        ];
        $user = mop::mock('\User', $properties);

        // bounus should be 149
        $bunus = 100 * 0.5 + 99;

        $vip = new Vip;
        $this->assertEquals($bunus, $vip->bonus($userId = 2));
    }
```

when mock instance whith properties, you still can use [`Expectation Declarations
` from `Mockery`](http://docs.mockery.io/en/latest/reference/expectations.html) to test you code.

```php
    /**
     * @test
     */
    public function notVipUserBonusShouldCorrect()
    {
        $properties = [
            'id' => 2,
            'isVip' => false,
            'rank' => 99
        ];
        $user = mop::mock('\User', $properties);

        // Expectation
        $user->shouldReceive('name_of_method');
            ->with($arg1, $arg2, ...);
            ->andReturn($value);

        // etc...
    }
```