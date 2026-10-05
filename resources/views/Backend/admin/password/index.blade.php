@extends('template.admin_master')
@section('Content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">{{ __('Change password') }}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4 col-4">
        <div class="card bg-primary p-2 text-dark bg-opacity-10">
            <div class="text-center mt-sm-0 mt-3 text-sm-end">
            </div>
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ (!empty($adminData->photo))? url('upload/admin_images/'.$adminData->photo):url('upload/no_image.png') }}" class="img-fluid avatar-md img-thumbnail" alt="{{ __('Personal picture') }}">
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
    <div class="col-md-8 col-8">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('update.password') }}" class="needs-validation" novalidate>
                    @csrf
                    <div class="position-relative mb-3">
                        <label for="oldpassword" class="form-label">{{ __('Current Password') }}</label>
                        <div class="input-group input-group-merge">
                            <input type="password" name="oldpassword" id="oldpassword" class="form-control @error('oldpassword')  
                                is-invalid @enderror">
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                        @error('oldpassword')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="position-relative mb-3">
                        <label for="newpassword" class="form-label">{{ __('New Password') }}</label>
                        <div class="input-group input-group-merge">
                            <input type="password" name="newpassword" id="newpassword" class="form-control @error('newpassword')  
                                is-invalid @enderror">
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                        @error('newpassword')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="position-relative mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }} </label>
                        <div class="input-group input-group-merge">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation')  
                                is-invalid @enderror" placeholder="{{ __('Confirm Password') }}">
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                        @error('password_confirmation')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="text-center mt-sm-0 mt-3 text-sm-end">
                        <input type="submit" class="btn btn-info waves-effect waves-light" value="{{ __('Edit') }} {{ __('Password') }}">
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- End col -->
</div> <!-- End row -->
@endsection
