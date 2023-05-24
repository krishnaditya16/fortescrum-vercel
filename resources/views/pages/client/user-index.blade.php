<x-app-layout>
    <x-slot name="title">{{ __('Client Users') }}</x-slot>
    <x-slot name="header_content">
        <h1>{{ __('Client\'s Account Data') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Client User</div>
        </div>
    </x-slot>
    <livewire:client.client-users>
</x-app-layout>