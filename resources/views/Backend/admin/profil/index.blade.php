@extends('template.admin_master')
@section('Content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">{{ __('Profile Information') }}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="text-center mt-sm-0 mt-3 text-sm-end">
                <a href="{{ route('edit.profile') }}" class="btn btn-primary">
                    <i class="mdi mdi-account-edit me-1"></i>{{ __('Edit profile') }}
                </a>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ (!empty($adminData->photo))? url('upload/admin_images/'.$adminData->photo):url('upload/no_image.png') }}" class="rounded-circle avatar-md img-thumbnail" alt="{{ __('Personal picture') }}">
                    <h4 class="mt-3 my-1">{{ __('Name') }} {{ __('and') }} {{ __('First Name') }}:<br>{{ $adminData->name }} {{ $adminData->username }}</h4>
                    <p class="mb-0 text-muted"><i class="mdi mdi-email-outline me-1"></i>{{ $adminData->email }}</p>
                    <hr class="bg-dark-lighten my-3">
                    <div class="row mt-3">
                        <div class="col-4">
                            {{ __('Local address') }}<i class="mdi mdi-google-maps"></i><br>
                            {{ $adminData->adresse }}
                        </div>
                        <div class="col-4">
                            {{ __('Phone') }}<i class="mdi mdi-phone"></i><br>
                            {{ $adminData->phone }}
                        </div>
                        <div class="col-4">
                            {{ __('Gender') }}<i class="mdi mdi-gender-female"></i>/<i class="mdi mdi-gender-male"></i><br>
                            {{ $adminData->gender }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End col -->
</div> <!-- End row -->
@endsection
