<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class EmailService extends AbstractService
{
    /**
     * Sending SalesManago e-mail.
     * Even if you set date to current timestamp, keep in mind
     * that there's around 10min delay due to SalesManago Queuing mechanisms
     * If you need to send an email immediately, use send method
     *
     * @param  string $owner Contact owner e-mail address
     * @param  array $data E-mail data
     *
     * @return array
     */
    public function create($owner, array $data)
    {
        $data['user'] = $owner;
        return $this->client->doPost('email/send', $data);
    }

    /**
     * Immediately send SalesManago email
     *
     * @param  string $owner Contact owner e-mail address
     * @param array $data
     *
     * @return array
     */
    public function send($owner, array $data)
    {
        $data['immediate'] = true;
        return $this->create($owner, $data);
    }
}
