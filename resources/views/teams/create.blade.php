<x-app-layout>
    <x-slot name="title">{{ __('Create Team') }}</x-slot>
    <x-slot name="header_content">
        <h1>Create Team</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="#">Team</a></div>
            <div class="breadcrumb-item">Create Team</div>
        </div>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @livewire('teams.create-team-form')
        </div>
    </div>
</x-app-layout>
