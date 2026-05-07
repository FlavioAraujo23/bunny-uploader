<?php

use Livewire\Component;
use App\Models\Video;
use Livewire\Attributes\On;

new class extends Component {
    public $videos = [];
    public $progresses = [];

    public function mount()
    {
        $this->videos = Video::with('collection')->latest()->get();
    }
    public function refreshVideos()
    {
        $this->videos = Video::with('collection')->latest()->get();
    }
    #[On('update-progress')]
    public function updateProgress(string $filename, int $percentage)
    {
        $this->progresses[$filename] = $percentage;
    }
};
?>

<div wire:poll.3s="refreshVideos">
    <div>
        @foreach ($videos as $video)
            <p>Status:
                <span>
                    <strong>
                        @switch($video->status)
                            @case('processing')
                                O video está sendo enviado...
                            @break

                            @case('done')
                                O video já foi enviado.
                            @break

                            @case('failed')
                                Ocorreu algum erro durante o envio do video.
                            @break

                            @default
                                O video está pendente de envio, aguarde que o processo já vai começar
                        @endswitch
                    </strong>
                </span>
            </p>
            <p>Nome: <span> <strong>{{ $video->name }}</strong></span></p>
            <p>Collection: <span> <strong>{{ $video->collection->name }}</strong></span></p>
            <div style="width: 100%; background: #eee;">
                <div style="width: {{ $progresses[$video->name] ?? 0 }}%; background: green; height: 10px;">
                </div>
            </div>
            <p>{{ $progresses[$video->name] ?? 0 }}%</p>
        @endforeach
    </div>
    {{-- Simplicity is an acquired taste. - Katharine Gerould --}}
</div>
