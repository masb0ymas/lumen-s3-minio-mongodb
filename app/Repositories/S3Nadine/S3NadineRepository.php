<?php

namespace App\Repositories\S3Nadine;

use App\Models\S3Nadine;
use Illuminate\Database\Eloquent\Collection;

class S3NadineRepository implements S3NadineRepositoryInterface
{
    public function all(): Collection
    {
        return S3Nadine::all();
    }

    public function create(array $s3nadine): S3Nadine
    {
        return S3Nadine::create($s3nadine);
    }

    /**
     * @param string $id
     * @return S3Nadine|null
     */
    public function findById(string $id)
    {
        return S3Nadine::find($id);
    }

    /**
     * @param S3Nadine $s3nadine
     * @param array $data
     * @return S3Nadine
     */
    public function update(S3Nadine $s3nadine, array $data): S3Nadine
    {
        return tap($s3nadine)->update($data);
    }

    public function delete(S3Nadine $s3nadine)
    {
        return $s3nadine->delete();
    }
}
