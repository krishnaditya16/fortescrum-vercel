<x-app-layout>
    <x-slot name="title">{{ __('Project List') }}</x-slot>
    <x-slot name="header_content">
        <h1>{{ __('Project Data') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Project</div>
        </div>
    </x-slot>
    <livewire:project.projects>

    @push('custom-scripts')
        <script src="{{ asset('stisla/js/shepherd/project-tour.js') }}"></script>
    @endpush
</x-app-layout>