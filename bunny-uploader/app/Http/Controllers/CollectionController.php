<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollectionRequest;
use App\Models\Collection;
use App\Services\BunnyCollectionService;


class CollectionController extends Controller
{
    public function __construct(private BunnyCollectionService $service) {}
    public function index()
    {
        $collections = $this->service->list();
        return view('collections.index', ['collections' => $collections]);
    }

    public function store(StoreCollectionRequest $request)
    {
        $this->service->create($request->name);
        return redirect()->route('collections.index')->with('success', 'COLLECTION CRIADA!');
    }

    public function select(Collection $collection)
    {

        session(['active_collection' => $collection->id]);
        return redirect()->route('collections.index');
    }
}