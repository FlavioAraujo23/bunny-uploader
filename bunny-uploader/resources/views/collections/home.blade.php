@php
    $activeCollection = optional(App\Models\Collection::find(session('active_collection')))->bunny_id;
@endphp
<x-layout>
    @foreach ($collections as $collection)
        <form action="{{ route('collections.select') }}" method="POST"
            style="{{ $activeCollection === $collection['guid'] ? 'border: 1px solid green;' : '' }}">
            @csrf
            <input type="hidden" name="bunny_id" value="{{ $collection['guid'] }}">
            <input type="hidden" name="name" value="{{ $collection['name'] }}">
            <p>Nome da collection: {{ $collection['name'] }}</p>
            <p>Total de videos: {{ $collection['videoCount'] }}</p>
            <button type="submit">Selecionar</button>
        </form>
    @endforeach
</x-layout>
