<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class CouponService extends AbstractService
{
    /**
     * Adding a new coupon to contact.
     *
     * @param  string $owner Contact owner e-mail address
     * @param  string $email Contact e-mail address
     * @param  array  $data  Client data
     */
    public function create($owner, $email, array $data)
    {
        $data = self::mergeData($data, [
            'owner' => $owner,
            'email' => $email,
        ]);

        return $this->client->doPost('contact/addContactCoupon', $data);
    }
}
