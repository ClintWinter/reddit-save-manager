<div
    x-data="{ focused: false, label: '{{ $label }}' }"
    x-on:focus-element.window="if ($event.detail === label) $refs.field.focus();"
    class="flex items-center mb-6"
>
    <label x-ref="label" x-bind:class="{ 'bg-main-blue rounded-l': focused }" class="w-32 h-12 flex items-center p-2">
        {{ ucfirst($label) }}
    </label>

    {{ $slot }}
</div>
