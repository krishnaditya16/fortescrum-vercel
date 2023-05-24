<x-app-layout>
    <x-slot name="title">{{ __('Project Meeting') }}</x-slot>
    <x-slot name="header_content">
        <h1>{{ __('Meeting') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Meeting</div>
        </div>
    </x-slot>

    <livewire:meeting.meetings>
        
</x-app-layout>