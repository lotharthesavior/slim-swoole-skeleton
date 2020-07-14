<?php

namespace App\Models\Abstractions;

use App\Models\Interfaces\SimpleCrudInterface;
use App\Drivers\Data\Interfaces\DataDriverInterface;

abstract class Model implements SimpleCrudInterface
{
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
     * @param int $id
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