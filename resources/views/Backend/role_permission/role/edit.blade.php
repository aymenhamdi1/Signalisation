@extends('template.admin_master')
@section('Content')
<script src="{{ asset('Backend/assets/js/jquery.min.js')}}"></script>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('DBR') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Add') }} {{ __('Role') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('Add') }} {{ __('Role') }}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{route('roles.update',$roles->id)}}" class="needs-validation" novalidate>
                    @csrf
                    <div class="position-relative mb-3">
                        <label for="name" class="form-label">{{ __('Role') }}</label>
                        <div class="input-group input-group-merge">
                            <input type="text" name="name" id="name" value="{{ $roles->name }}" class="form-control @error('name')  
                        is-invalid @enderror">
                        </div>
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-center mt-sm-0 mt-3 text-sm-end">
                        @if(Auth::user()->can('permission:roles.update'))
                        <button type="submit" class="btn btn-info float-end">{{ __('Edit') }}</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- End col -->
</div>
@endsection
