@props(['type' => 'submit'])

<button {{ $attributes->merge(['type' => $type, 'class' => 'btn text-white', 'style' => 'background-color: #593E75;']) }}>
    {{ $slot }}
</button>
