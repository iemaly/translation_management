<?php

namespace App\Services;

use App\Models\Translation;
use App\Repositories\TranslationRepository;

class TranslationService
{
    public function __construct(
        protected TranslationRepository $repo
    ) {}

    public function getAll()
    {
        return $this->repo->all();
    }

    public function store(array $data)
    {
        return $this->repo->store($data);
    }

    public function update(Translation $translation, array $data)
    {
        return $this->repo->update($translation, $data);
    }

    public function delete(Translation $translation)
    {
        return $this->repo->delete($translation);
    }

    public function search(array $filters)
    {
        return $this->repo->search($filters);
    }

    public function exportJson(string $locale)
    {
        return $this->repo->exportByLocale($locale);
    }
}
