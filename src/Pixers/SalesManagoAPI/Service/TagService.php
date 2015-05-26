<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class TagService extends AbstractService
{
    /**
     * Retriving all tags.
     *
     * @param string $owner Contact owner e-mail address
     * @param array  $data  Request data
     *
     * @return array
     */
    public function getAll($owner, array $data)
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/tags', $data);
    }

    /**
     * Manage contact tags.
     *
     * @param string $owner Contact owner e-mail address
     * @param string $email Contact e-mail address
     * @param array  $data  Tags data
     *
     * @return array
     */
    public function modify($owner, $email, array $data)
    {
        $data = self::mergeData($data, [
            'email' => $email,
            'owner' => $owner,
        ]);

        return $this->client->doPost('contact/managetags', $data);
    }
}
