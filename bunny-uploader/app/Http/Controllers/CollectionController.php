<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCollectionRequest;
use App\Models\Collection;
use App\Services\BunnyCollectionService;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function __construct(private BunnyCollectionService $service) {}
    public function index()
    {
        $collections = $this->service->list();
        return view('collections.index', ['collections' => $collections]);
    }

    public function home()
    {
        $collections = $this->service->listFromBunny();
        return view('collections.home', ['collections' => $collections]);
    }

    public function store(StoreCollectionRequest $request)
    {
        $this->service->create($request->name);
        return redirect()->route('collections.index')->with('success', 'COLLECTION CRIADA!');
    }

    public function select(Request $request)
    {
        $collection = Collection::firstOrCreate(['bunny_id' => $request->bunny_id], ['name' => $request->name]);

        session(['active_collection' => $collection->id]);
        return redirect()->route('collections.index');
    }
}