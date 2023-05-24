<x-app-layout>
    <x-slot name="title">{{ __('Project Finance') }}</x-slot>
    <x-slot name="header_content">
        <h1>{{ __('Finance') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Finance</div>
        </div>
    </x-slot>

    <livewire:finance.finances>
        
</x-app-layout>