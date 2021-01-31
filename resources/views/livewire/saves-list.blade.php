<div class="w-full flex flex-col pt-8 pb-20">
    {{-- <x-pagination /> --}}

    <section class="cards flex flex-wrap justify-start items-stretch">
        @foreach($saves as $save)
            <livewire:save-card :save="$save" />
        @endforeach
    </section>

    {{-- <x-pagination /> --}}
</div>
