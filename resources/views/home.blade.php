@extends('layouts.app')

@section('content')

<div id="app" class="text-white min-h-screen flex flex-col font-body">
    <x-nav :user="$user" />

    {{-- error flash --}}
    @if($errors->any())
        <div v-if="errors.length > 0" class="px-5 py-2 bg-red-800 fixed shadow-md inset-x-0 top-0 z-20">
            <p class="text-lg font-bold color-white" v-for="(error, index) in errors" :key="index">
                {{ $errors->first() }}
            </p>
        </div>
    @endif

    {{-- <livewire:save-filters-modal /> --}}

    {{-- <livewire:save-search /> --}}

    <main class="flex justify-center bg-gray-900 flex-grow">
        <div class="container">
            <livewire:saves-list :user="$user" />
        </div>
    </main>
</div>

@endsection
