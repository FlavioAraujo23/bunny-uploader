<?php

namespace App\Http\Controllers;

use App\Exceptions\CollectionNotFoundException;
use App\Jobs\ProcessVideoUpload;
use App\Models\Video;
use App\Services\BunnyVideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Collection;

class VideoController extends Controller
{
    public function __construct(private BunnyVideoService $service) {}

    public function index()
    {

        $videos = Video::with('collection')->get();

        return view('videos.index', ['videos' => $videos]);
    }

    public function store(Request $request)
    {
        $activeCollection = session('active_collection');
        if (!isset($activeCollection)) {
            return redirect()->route('videos.index')->with('Error', 'Nenhuma collection está ativa!');
        }

        if (!$request->hasFile('videos')) {
            return redirect()->route('videos.index')->with('Error', 'Existe algo de errado com o video enviado.');
        }

        $data = $request->file('videos');

        foreach ($data as $videoFile) {
            $tempPath = $videoFile->store('temp');

            $video = Video::create([
                'collection_id' => $activeCollection,
                'status' => Video::STATUS_PENDING,
                'name' => $videoFile->getClientOriginalName()
            ]);

            ProcessVideoUpload::dispatch($video, $tempPath, $activeCollection);
        }

        return redirect()->route('videos.index')->with('success', 'Videos enviados para o bunny!');
    }

    public function update(Request $request, Video $video)
    {
        $video->update(['name' => $request->input('name')]);
        return redirect()->route('videos.index')->with('success', 'O nome do video foi atualizado com sucesso!');
    }

    public function authorize(Request $request)
    {
        $activeCollection = session('active_collection');
        if (!$activeCollection) {
            throw new CollectionNotFoundException();
        }
        $collection = Collection::find($activeCollection);
        if (!$collection) {
            throw new CollectionNotFoundException('Collection ativa não encontrad no banco');
        }

        $video = $this->service->createVideo($request->name, $collection->bunny_id);
        Log::info('video criado', $video);

        Video::create([
            'collection_id' => $activeCollection,
            'status' => Video::STATUS_PENDING,
            'name' => $request->name
        ]);
        Log::info('salvo no banco, gerando tus credentials');
        $tusCredentials = $this->service->generateTusCredentials($video['guid']);
        Log::info('tus credentials geradas', $tusCredentials);
        return response()->json($tusCredentials);
    }
}