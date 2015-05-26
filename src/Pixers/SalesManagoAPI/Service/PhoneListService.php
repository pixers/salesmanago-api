<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class PhoneListService extends AbstractService
{
    /**
     * Add a contact to phone list.
     *
     * @param string $email Contact e-mail address
     *
     * @return array
     */
    public function add($email)
    {
        return $this->client->doPost('contact/phoneoptin', [
            'email' => $email,
        ]);
    }

    /**
     * Remove a contact to phone list.
     *
     * @param string $email Contact e-mail address
     *
     * @return array
     */
    public function remove($email)
    {
        return $this->client->doPost('contact/phoneoptout', [
            'email' => $email,
        ]);
    }
}
