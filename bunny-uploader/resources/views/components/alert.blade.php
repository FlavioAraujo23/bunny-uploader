@props(['type' => 'info', 'message' => null])
@if (isset($message))
    <div {{ $attributes->merge(['class' => 'alert alert-' . $type]) }}>
        {{ $message }}
    </div>
@endif
