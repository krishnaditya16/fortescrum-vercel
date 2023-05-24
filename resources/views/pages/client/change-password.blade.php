<x-app-layout>
    <x-slot name="title">{{ __('Update Password') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('client.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Update Password') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('client-user.index') }}">Client Users</a></div>
            <div class="breadcrumb-item">Change User Password</div>
        </div>
    </x-slot>

    <h2 class="section-title">Update Password </h2>
    <p class="section-lead mb-3">
        On this page you can edit user's password.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Update Password : {{ $user->name }} </h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('user.password', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Password</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="password" class="form-control" name="password">
                                @error('password') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Confirm Password</label>
                            <div class="col-sm-12 col-md-7">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                                @error('password') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary">Change Password</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>