<?php

namespace App\Repositories\Action;

use App\Models\Action;
use Illuminate\Database\Eloquent\Collection;

interface ActionRepositoryInterface
{
    public function all(): Collection;

    public function create(array $action): Action;

    /**
     * @param string $id
     * @return Action|null
     */
    public function findByID(string $id);

    public function update(Action $action, array $data): Action;

    public function delete(Action $action);
}
