<x-app-layout>    
    <x-slot name="title">{{ __('Edit Client') }}</x-slot>
    <x-slot name="header_content">
        <div class="section-header-back">
            <a href="{{ route('client.index') }}" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>{{ __('Edit Client') }}</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="{{ route('client.index') }}">Edit</a></div>
            <div class="breadcrumb-item">Edit</div>
        </div>
    </x-slot>

    <h2 class="section-title">Edit Client </h2>
    <p class="section-lead mb-3">
        On this page you can edit existing client information.
    </p>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Edit Client</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('client.update', $client->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Company Name</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="name" value="{{ $client->name }}">
                                @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="email" value="{{ $client->email }}">
                                @error('email') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Phone Number</label>
                            <div class="col-sm-12 col-md-7">
                                <input type="text" class="form-control" name="phone_number" value="{{ $client->phone_number }}">
                                @error('phone_number') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Location</label>
                            <div class="col-sm-12 col-md-7">
                                <textarea class="form-control" name="address">{{ $client->address }}</textarea>
                                @error('address') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Assigned Client's User</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="user_id">
                                    <option selected disabled> Select User </option>
                                    @foreach ($data as $user)
                                    <option value="{{ $user->id }}"  @if($client->user_id=="$user->id") selected="selected" @endif>{{ $user->name }}</option>
                                    @endforeach
                                </select>
                                @error('user_id') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>

                        <div class="form-group row mb-4">
                            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Status</label>
                            <div class="col-sm-12 col-md-7">
                                <select class="form-control select2" name="status">
                                    <option value="0" @if($client->status=="0") selected="selected" @endif>Active</option>
                                    <option value="1" @if($client->status=="1") selected="selected" @endif>Suspended</option>
                                </select>
                            </div>
                            @error('status') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>

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