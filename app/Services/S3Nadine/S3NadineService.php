<?php


namespace App\Services\S3Nadine;

use App\Models\S3Nadine;
use App\Repositories\S3Nadine\S3NadineRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class S3NadineService
{
    /**
     * @var S3NadineRepositoryInterface
     */
    protected $s3NadineRepository;

    public function __construct(S3NadineRepositoryInterface $s3NadineRepository)
    {
        $this->s3NadineRepository = $s3NadineRepository;
    }

    public function all(): Collection
    {
        return $this->s3NadineRepository->all();
    }

    public function findById(string $id): S3Nadine
    {
        return $this->s3NadineRepository->findById($id);
    }

    public function create(array $request): S3Nadine
    {
        return $this->s3NadineRepository->create($request);
    }

    /**
     * @param string $id
     * @param array $data
     * @return S3Nadine|null
     */
    public function update(string $id, array $data)
    {
        $s3nadine = $this->s3NadineRepository->findById($id);

        if ($s3nadine == null) {
            return null;
        }

        return $this->s3NadineRepository->update($s3nadine, $data);
    }

    /**
     * @param string $id
     * @return bool
     */
    public function delete(string $id): bool
    {
        $data = $this->s3NadineRepository->findById($id);
        // dd($data);

        if ($data == null) {
            return false;
        }

        $this->s3NadineRepository->delete($data);

        return true;
    }
}
