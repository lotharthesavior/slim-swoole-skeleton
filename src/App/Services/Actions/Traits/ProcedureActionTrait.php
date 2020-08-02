<?php

namespace App\Services\Actions\Traits;

/**
 * Action's Trait for Controller similar procedures.
 */

trait ProcedureActionTrait
{
    /**
     * @param array $data
     */
    public function __invoke(array $data)
    {
        dd($this, $data);
        $this->validateData($data);

        $this->data = $data;

        return $this->execute();
    }
}
