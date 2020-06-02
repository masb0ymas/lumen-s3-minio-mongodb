<?php


namespace App\Services\Action;


use App\Models\Action;
use App\Repositories\Action\ActionRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ActionService
{
    /**
     * @var ActionRepositoryInterface
     */
    protected $actionRepository;

    public function __construct(ActionRepositoryInterface $actionRepository)
    {
        $this->actionRepository = $actionRepository;
    }

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return $this->actionRepository->all();
    }

    /**
     * @param array $action
     * @return Action
     */
    public function create(array $action): Action
    {
        return $this->actionRepository->create($action);
    }

    /**
     * @param string $id
     * @param array $data
     * @return Action|null
     */
    public function update(string $id, array $data)
    {
        $action = $this->actionRepository->findByID($id);

        if ($action == null) {
            return null;
        }

        return $this->actionRepository->update($action, $data);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $action = $this->actionRepository->findByID($id);

        if ($action == null) {
            return false;
        }

        $this->actionRepository->delete($action);

        return true;
    }
}
