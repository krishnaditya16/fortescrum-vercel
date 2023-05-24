<x-app-layout>
    <x-slot name="title">{{ __('Overall Backlog Data') }}</x-slot>
    <x-slot name="header_content">
        <h1>{{ __('Overall Backlog Data') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Overall Backlog</div>
        </div>
    </x-slot>
    <livewire:backlog.backlogs>
</x-app-layout>