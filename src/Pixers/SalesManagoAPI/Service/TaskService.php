<?php

namespace Pixers\SalesManagoAPI\Service;

/**
 * @author Sylwester Łuczak <sylwester.luczak@pixers.pl>
 */
class TaskService extends AbstractService
{
    /**
     * Create new task.
     *
     * @param  array $data Task data
     * @return array
     */
    public function create(array $data)
    {
        $data = self::mergeData($data, [
            'finished' => false,
            'smContactTaskReq' => [
                'id' => false,
            ],
        ]);

        return $this->client->doPost('contact/updateTask', $data);
    }

    /**
     * Update task.
     *
     * @param  string $taskId Task internal ID
     * @param  array  $data   Task data
     * @return array
     */
    public function update($taskId, array $data)
    {
        $data = self::mergeData($data, [
            'finished' => false,
            'smContactTaskReq' => [
                'id' => $taskId,
            ],
        ]);

        return $this->client->doPost('contact/updateTask', $data);
    }

    /**
     * Delete task.
     *
     * @param  string $taskId Task internal ID
     * @return array
     */
    public function delete($taskId)
    {
        return $this->client->doPost('contact/updateTask', [
            'finished' => true,
            'smContactTaskReq' => [
                'id' => $taskId,
            ],
        ]);
    }
}
