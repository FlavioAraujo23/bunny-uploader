<x-layout>
    <x-alert :message="session('success')" />

    <form method="POST" action="{{ route('collections.store') }}">
        @csrf
        <input type="text" name="name" id="name">

        <button type="submit">Criar</button>
        @if ($errors->first('name'))
            <div class="text-red-600 mb-1 border-b-red-600">
                {{ $errors->first('name') }}
            </div>
        @endif
    </form>

    @foreach ($collections as $item)
        <div @style(['border: 1px solid green' => $item->id === session('active_collection')])>
            <p>{{ $item->name }}</p>
            <form action="{{ route('collections.select', $item) }}" method="post">
                @csrf
                <button type="submit">Selecionar</button>
            </form>
        </div>
    @endforeach
</x-layout>
