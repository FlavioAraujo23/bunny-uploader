@foreach ($videosExported as $video)
    <p>Nome: {{ $video['name'] }}</p>
    <p>Link: <a href="{{ $video['url'] }}" target="_blank">{{ $video['url'] }}</a></p>
    <button onclick="navigator.clipboard.writeText('{{ $video['url'] }}')">Copiar</button>
@endforeach
