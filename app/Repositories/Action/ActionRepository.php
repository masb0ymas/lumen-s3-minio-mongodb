<?php

namespace App\Repositories\Action;


use App\Models\Action;
use Illuminate\Database\Eloquent\Collection;

class ActionRepository implements ActionRepositoryInterface
{
    public function all(): Collection
    {
        return Action::all();
    }

    public function create(array $action): Action
    {
        return Action::create($action);
    }

    /**
     * @param string $id
     * @return Action|null
     */
    public function findByID(string $id)
    {
        return Action::find($id);
    }

    public function update(Action $action, array $data): Action
    {
        return tap($action)->update($data);
    }

    public function delete(Action $action)
    {
        $action->delete();
    }
}
