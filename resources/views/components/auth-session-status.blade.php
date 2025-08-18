@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'alert alert-success fw-medium']) }}>
        {{ $status }}
    </div>
@endif
