<x-app-layout>
    <x-slot name="title">{{ __('Project Reports') }}</x-slot>
    <x-slot name="header_content">
        <h1>{{ __('Report') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Report</div>
        </div>
    </x-slot>

    <livewire:report.reports>
        
</x-app-layout>