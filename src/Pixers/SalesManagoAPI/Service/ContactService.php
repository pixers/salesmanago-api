<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class ContactService extends AbstractService
{
    /**
     * Adding a new contact.
     *
     * @param string $owner Contact owner e-mail address
     * @param array  $data  Contact data
     *
     * @return array
     */
    public function create($owner, array $data)
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/insert', $data);
    }

    /**
     * Update contact data.
     *
     * @param string $owner Contact owner e-mail address
     * @param string $email Contact e-mail address
     * @param array  $data  Contact data
     *
     * @return array
     */
    public function update($owner, $email, array $data)
    {
        $data = self::mergeData($data, [
            'owner' => $owner,
            'email' => $email,
        ]);

        return $this->client->doPost('contact/update', $data);
    }

    /**
     * Upsert contact data.
     *
     * @param string $owner Contact owner e-mail address
     * @param string $email Contact e-mail address
     * @param array  $data  Contact data
     *
     * @return array
     */
    public function upsert($owner, $email, array $data)
    {
        $data = self::mergeData($data, [
            'owner'     => $owner,
            'contact'   =>  [
                'email' =>  $email
            ]
        ]);

        return $this->client->doPost('contact/upsert', $data);
    }    

    /**
     * Deleting contact.
     *
     * @param string $owner Contact owner e-mail address
     * @param string $email Contact e-mail address
     * @param array  $data  Client data
     *
     * @return array
     */
    public function delete($owner, $email, array $data)
    {
        $data = self::mergeData($data, [
            'owner' => $owner,
            'email' => $email,
        ]);

        return $this->client->doPost('contact/delete', $data);
    }

    /**
     * Checking whether the contact is already registered.
     *
     * @param string $owner Contact owner email address
     * @param string $email Contact email address
     *
     * @return array
     */
    public function has($owner, $email)
    {
        return $this->client->doPost('contact/hasContact', [
            'email' => $email,
            'owner' => $owner,
        ]);
    }

    /**
     * Import contacts list by the e-mail addresses.
     *
     * @param string $owner Contact owner e-mail address
     * @param array  $data  Request data
     *
     * @return array
     */
    public function listByEmails($owner, array $data)
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/list', $data);
    }

    /**
     * Import contacts list by the SalesManago IDS.
     *
     * @param string $owner Contact owner e-mail address
     * @param array  $data  Request data
     *
     * @return array
     */
    public function listByIds($owner, array $data)
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/listById', $data);
    }

    /**
     * Import list of last modyfied contacts.
     *
     * @param string $owner Contact owner e-mail address
     * @param array  $data  Request data
     *
     * @return array
     */
    public function listRecentlyModified($owner, array $data)
    {
        $data['owner'] = $owner;

        return $this->client->doPost('contact/modifiedContacts', $data);
    }

    /**
     * Import data about recently active contacts.
     *
     * @param array $data Request data
     *
     * @return array
     */
    public function listRecentActivity(array $data)
    {
        return $this->client->doPost('contact/recentActivity', $data);
    }
}
