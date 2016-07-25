<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class SystemService extends AbstractService
{
    /**
     * Register system account (only for SalesManago partners).
     *
     * @param  string $data Account data
     * @return array
     */
    public function registerAccount(array $data)
    {
        return $this->client->doPost('system/registeraccount', $data);
    }

    /**
     * Temporary authorise.
     *
     * @param  array $data
     * @return array
     */
    public function authorise(array $data)
    {
        return $this->client->doPost('system/authorise', $data);
    }
}
