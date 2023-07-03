<?php

namespace common\tests\unit\models;

use Codeception\Test\Unit;
use common\components\ExactOnline;
use common\tests\UnitTester;
use common\fixtures\UserFixture;

/**
 * Exact form test
 */
class ExactTest extends Unit
{
    /**
     * @var UnitTester
     */
    protected UnitTester $tester;


    /**
     * @return array
     */
    public function _fixtures(): array
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ]
        ];
    }

    public function testLoginNoUser(): void
    {
        /*We dont have to mock exact online bcs we pass a testing true which will set us as "authenticatie" inside the exactonline class*/
        $exactOnline = new ExactOnline(true);

        /*The /unit/mocks/SyncSubscriptionLines.json should be returned as the HTTP response*/
        $exactOnline->getSubscriptionLines();

        /*The /unit/mocks/SyncSubscriptionLines1.json and /unit/mocks/SyncSubscriptionLines2.json should be returned as the HTTP response*/
        $exactOnline->getSubscriptionLinesAsGenerator();

    }
}
