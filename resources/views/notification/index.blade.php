<x-app-layout>
    <x-slot name="title">{{ __('Notifications Data') }}</x-slot>
    <x-slot name="header_content">
        <h1>{{ __('Notifications Data') }}</h1>

        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item">Notification</div>
        </div>
    </x-slot>

    <h2 class="section-title">Your Notifications Data</h2>
    <p class="section-lead mb-3">
        All notification data from your account are listed here.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <livewire:notification.notification-table/>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

