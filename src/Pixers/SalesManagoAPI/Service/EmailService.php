<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class EmailService extends AbstractService
{
    /**
     * Sending SalesManago e-mail.
     *
     * @param  array $data E-mail data
     * @return array
     */
    public function create(array $data)
    {
        return $this->client->doPost('email/send', $data);
    }
}
