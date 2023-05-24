<x-app-layout>
    <x-slot name="title">{{ __('Overall Task Data') }}</x-slot>
    <x-slot name="header_content">
        <h1>{{ __('Overall Task Data') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Overall Task</div>
        </div>
    </x-slot>

    <h2 class="section-title">Tasks Data</h2>
    <p class="section-lead mb-3">
        Overall tasks data from all project on your team are listed here.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <livewire:task.task-table />
                </div>
            </div>
        </div>
    </div>

</x-app-layout>