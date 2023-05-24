<x-app-layout>
    <x-slot name="title">{{ __('All Users') }}</x-slot>
    <x-slot name="header_content">
        <h1>{{ __('User Data') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">User</div>
        </div>
    </x-slot>
    
    <livewire:user.users>
</x-app-layout>