<x-form-field :label="$label">
    <select
        x-ref="field"
        x-on:focus="focused = true"
        x-on:blur="focused = false"
        x-bind:class="{ 'rounded-l': ! focused }"
        class="h-12 flex-grow text-white bg-transparent p-2 text-base bg-transparent border-2 border-inactive focus:border-main-blue outline-none rounded-r"
        {{ $attributes }}
    >
        {{ $slot }}
    </select>
</x-form-field>
