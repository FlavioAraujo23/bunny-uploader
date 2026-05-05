<form method="POST" action="{{ route('videos.store') }}" enctype="multipart/form-data">
    @csrf

    <input type="file" multiple name="videos[]" id="videos">
    <button type="submit">Enviar videos</button>
</form>

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

    <form method="POST" action="{{ route('videos.update', $video) }}">
        @method('PUT')
        @csrf
        <input type="text" name="name" id="name" value="{{ $video->name }}">
        <button type="submit">Salvar</button>
    </form>
@endforeach
