<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;
use App\Services\TranslationService;
use App\Http\Requests\Translation\StoreRequest;
use App\Http\Requests\Translation\UpdateRequest;

class TranslationController extends Controller
{
    public function __construct(
        protected TranslationService $service
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->service->getAll();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        return $this->service->store($request->validated());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Translation $translation)
    {
        return $this->service->update($translation, $request->validated());
    }

    public function destroy(Translation $translation)
    {
        $this->service->delete($translation);
        return response()->noContent();
    }

    public function search(Request $request)
    {
        return $this->service->search($request->only('tag', 'key', 'content'));
    }

    public function export(Request $request)
    {
        $locale = $request->get('locale', 'en');
        return response()->json(
            $this->service->exportJson($locale), 200, [], JSON_UNESCAPED_UNICODE
        );
    }
}
