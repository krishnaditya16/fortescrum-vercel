<x-app-layout>
    <x-slot name="title">{{ __('Create Client User') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('client.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Add Client\'s User') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('user.index') }}">Client User</a></div>
            <div class="breadcrumb-item">Create</div>
        </div>
    </x-slot>

    <h2 class="section-title">Create New </h2>
    <p class="section-lead mb-3">
        On this page you can create a new client's user and fill in all fields.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Add New Client's User</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('client-user.store') }}" method="post">
                        @csrf
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                                @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="email" value="{{ old('email') }}">
                                @error('email') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Team</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="current_team_id">
                                    <option selected disabled> Select Team </option>
                                    @foreach ($data as $team)
                                    <option value="{{ $team->id }}">{{ $team->name }}</option>
                                    @endforeach
                                </select>
                                @error('current_team_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Company Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="company_name" value="{{ old('company_name') }}">
                                @error('company_name') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Company Email</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="company_email" value="{{ old('company_email') }}">
                                @error('company_email') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Phone Number</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="phone_number" value="{{ old('phone_number') }}">
                                @error('phone_number') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Location</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control" name="address">{{ old('address') }}</textarea>
                                @error('address') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

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
                                <button type="submit" class="btn btn-primary">Create Data</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>

</x-app-layout>
