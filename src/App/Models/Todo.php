<?php

namespace App\Models;

use App\Models\Interfaces\SimpleCrudInterface;
use App\Drivers\Data\Interfaces\DataDriverInterface;

class Todo implements SimpleCrudInterface
{
    /** @var string */
    protected $table = 'todos';

    /** @var DataDriverInterface */
    protected $dataDriver;

    public function __construct(DataDriverInterface $dataDriver)
    {
        $this->dataDriver = $dataDriver;
    }

    /**
     * @param array $data
     *
     * @return int|bool
     */
    public function create(array $data) 
    {
        return $this->dataDriver->create($this->table, $data);
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function update(int $id, array $data)
    {
        return $this->dataDriver->update($this->table, $id, $data);
    }

    /**
     * @param int|null $id
     *
     * @return array
     */
    public function get($id = null)
    {
        return $this->dataDriver->get($this->table, $id);
    }

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id)
    {
        return $this->dataDriver->delete($this->table, $id);
    }

}