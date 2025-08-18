@props(['name', 'show' => false, 'maxWidth' => '2xl'])

<div 
    x-data="{ show: @js($show) }"
    x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="modal fade"
    tabindex="-1"
    style="display: none;"
>
    <div class="modal-dialog">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>
