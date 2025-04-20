<?php

namespace App\Repositories;

use App\Models\Translation;
use App\Http\Resources\TranslationResource;

class TranslationRepository
{
    public function all()
    {
        return TranslationResource::collection(Translation::paginate());
    }

    public function store(array $data)
    {
        return Translation::create($data);
    }

    public function update(Translation $translation, array $data)
    {
        $translation->update($data);
        return $translation;
    }

    public function delete(Translation $translation)
    {
        return $translation->delete();
    }

    public function search(array $filters)
    {
        $query = Translation::query();

        if (!empty($filters['tag'])) {
            $query->whereJsonContains('tags', $filters['tag']);
        }

        if (!empty($filters['key'])) {
            $query->where('key', 'like', '%' . $filters['key'] . '%');
        }

        if (!empty($filters['content'])) {
            $query->where('content', 'like', '%' . $filters['content'] . '%');
        }

        return TranslationResource::collection( $query->paginate());
    }

    public function exportByLocale(string $locale)
    {
        return Translation::where('locale', $locale)
            ->select('key', 'content')
            ->get()
            ->pluck('content', 'key');
    }
}
