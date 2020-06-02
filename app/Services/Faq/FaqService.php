<?php


namespace App\Services\Faq;

use App\Models\Faq;
use App\Repositories\Faq\FaqRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class FaqService
{
    /**
     * @var FaqRepositoryInterface
     */
    protected $faqRepository;

    public function __construct(FaqRepositoryInterface $faqRepository)
    {
        $this->faqRepository = $faqRepository;
    }

    public function all(): Collection
    {
        return $this->faqRepository->all();
    }

    public function create(array $request): Faq
    {
        return $this->faqRepository->create($request);
    }
}
