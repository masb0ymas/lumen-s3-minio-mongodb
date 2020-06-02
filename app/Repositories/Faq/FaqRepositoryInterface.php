<?php


namespace App\Repositories\Faq;

use App\Models\Faq;
use Illuminate\Database\Eloquent\Collection;

interface FaqRepositoryInterface
{
    public function all(): Collection;
    public function create(array $faq): Faq;
}
