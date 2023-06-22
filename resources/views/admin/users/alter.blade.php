@extends('adminlte::page')
@section('title', $action . ' Customer')
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
    <h1>{{ $action }} Customer</h1>
@stop

@section('content')
    <div class="card">
        <form action="{{ $actionUrl }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if ($action != 'Add') @method('PUT') @endif
            <div class="card-header">
                <div class="float-right">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-default"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
                </div>
                <p>Please add appropriate details to {{ $action }} Customer</p>
            </div>
            <div class="card-body">

                <div class="row">

                    <x-form-input name="name" type="text" label="Full Name" value="{{ $user->name }}" />

                    <x-form-input name="email" type="email" label="Email Address" value="{{ $user->email }}" />

                    <x-form-input name="phone" type="number" label="Mobile Number" placeholder="Enter Mobile Number here" value="{{ $user->phone }}" />

                    @if ($action != 'Add')
                    <div class="form-group col-md-6"></div>
                    @else
                    <x-form-input name="password" type="password" label="Password" />
                    @endif

                    <div class="form-group col-md-12">
                        <label>Set location on map</label>
                        <input id="map-canvas-input" class="controls form-control" style="width: 50%;margin-left:15em;border-color:black;box-shadow:0 0 21px #000000a3;" type="text" placeholder="Search Box" />
                        <div id="map-canvas" style="min-height: 500px;"></div>
                    </div>

                    <x-form-input name="address_lat" id="address_lat" readonly="true" type="text" label="Address Latitude" placeholder="Enter Address Latitude" value="22.9755" />
                    {{-- {{ $user->address_lat }} --}}

                    <x-form-input name="address_long" id="address_long" readonly="true" type="text" label="Address Longitude" placeholder="Enter Address Longitude" value="72.6155" />
                    {{-- {{ $user->address_long }} --}}

                    <x-form-textarea size="12" name="address" label="Address" placeholder="Enter Address" value="{{ $user->address }}" />

                    <div class="form-group col-md-6">
                        <label>Is Blocked ?</label>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-success" type="radio" id="statusYes" value="Yes" {{ $user->is_blocked == "Yes" ? 'checked' : '' }} name="is_blocked">
                                <label for="statusYes" class="custom-control-label">Yes</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-danger" type="radio" id="statusNo" value="No" {{ $user->is_blocked == "No" ? 'checked' : '' }} name="is_blocked">
                                <label for="statusNo" class="custom-control-label">No</label>
                            </div>
                        </div>
                        @error('status')<p classs="text-danger">{{ $message  }}</p>@enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label>Status</label>
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-success" type="radio" id="statusActive" value="Active" {{ $user->status == "Active" ? 'checked' : '' }} name="status">
                                <label for="statusActive" class="custom-control-label">Active</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input class="custom-control-input custom-control-input-danger" type="radio" id="statusInActive" value="InActive" {{ $user->status == "InActive" ? 'checked' : '' }} name="status">
                                <label for="statusInActive" class="custom-control-label">InActive</label>
                            </div>
                        </div>
                        @error('status')<p classs="text-danger">{{ $message  }}</p>@enderror
                    </div>

                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">{{ $action }} Data</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
@stop

@section('js')
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{config('app.google_map_key')}}&callback=initAutocomplete&libraries=places" defer ></script>
@endsection
