<x-app-layout>
    <x-slot name="title">{{ __('Client Data') }}</x-slot>
    <x-slot name="header_content">
        <h1>{{ __('Client Data') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Client</div>
        </div>
    </x-slot>
    <livewire:client.clients>
</x-app-layout>