<?php


namespace App\Repositories\S3Nadine;

use App\Models\S3Nadine;
use Illuminate\Database\Eloquent\Collection;

interface S3NadineRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param array $s3nadine
     * @return S3Nadine
     */
    public function create(array $s3nadine): S3Nadine;

    /**
     * @param string $id
     * @return S3Nadine|null
     */
    public function findById(string $id);
    /**
     * @param S3Nadine $s3nadine
     * @param array $data
     * @return S3Nadine
     */
    public function update(S3Nadine $s3nadine, array $data): S3Nadine;

    /**
     * @param S3Nadine $s3nadine
     * @return void
     */

    public function delete(S3Nadine $s3nadine);
}
