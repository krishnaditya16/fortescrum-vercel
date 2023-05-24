<x-app-layout>
    <x-slot name="title">{{ __('Edit User') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ url()->previous() }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Edit User') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('user.index') }}">User</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </x-slot>

    <h2 class="section-title">Edit User </h2>
    <p class="section-lead mb-3">
        On this page you can edit existing user information.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit User</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('user.update', $user->id) }}" method="post">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Team</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" value="{{ $team->name }}" readonly>
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                                @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                                @error('email') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        {{-- <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Team</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="current_team_id">
                                    <option selected disabled> Select Team </option>
                                    @foreach ($data as $team)
                                    <option value="{{ $team->id }}" @if($user->current_team_id=="$team->id") selected="selected" @endif>{{ $team->name }}</option>
                                    @endforeach
                                </select>
                                @error('current_team_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        @foreach ($data as $team)
                        <input type="hidden" name="team_id" value="{{ $team->id }}">
                        @endforeach --}}

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                            <div class="col-sm-12 col-md-7">
                                <button type="submit" class="btn btn-primary">Update Data</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
