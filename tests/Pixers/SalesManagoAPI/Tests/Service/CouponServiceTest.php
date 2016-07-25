<?php

namespace Pixers\SalesManagoAPI\Tests\Service;

use Pixers\SalesManagoAPI\Service\CouponService;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class CouponServiceTest extends AbstractServiceTest
{
    /**
     * @var CouponService
     */
    protected static $couponService;

    /**
     * Setup coupon service.
     */
    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$couponService = new CouponService(self::$salesManagoClient);
    }

    public function testCreate()
    {
        $data = [
            'name' => 'testCouponName',
            'length' => 6,
            'valid' => date('c', time()),
        ];

        $response = self::$couponService->create(self::$config['owner'], self::$config['contactEmail'], $data);
    }
}
