@extends('template.admin_master')
@section('Content')
<script src="{{ asset('Backend/assets/js/jquery.min.js')}}"></script>
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
            <div class="card-body">
                <form method="post" action="{{ route('store.profile') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="billing-first-name" class="form-label">{{ __('Name') }}</label>
                                <input class="form-control" name="name" value="{{ $editData->name }}" type="text" placeholder="{{ __('Name') }}" id="billing-first-name" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="billing-last-name" class="form-label">{{ __('First Name') }}</label>
                                <input class="form-control" name="username" value="{{ $editData->username }}" type="text" placeholder="{{ __('First Name') }}" id="billing-last-name" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="billing-phone" class="form-label">{{ __('Phone') }}<span class="text-danger">*</span></label>
                                <input class="form-control" name="phone" value="{{ $editData->phone }}" type="text" placeholder="(xx) xxx xxxx xxx" id="billing-phone" />
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="billing-email-address" class="form-label">{{ __('Email') }}<span class="text-danger">*</span></label>
                                <input class="form-control" name="email" value="{{ $editData->email }}" type="email" placeholder="{{ __('Email') }}" id="billing-email-address" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="billing-email-address" class="form-label">{{ __('Gender') }}</label>
                                <select class="form-select mb-3" name="gender">
                                    <option selected>{{ __('Select Gender') }}</option>
                                    <option value="{{ __('Male') }}" {{ ($editData->gender == "Male" ? "selected": "") }}>{{ __('Male') }}</option>
                                    <option value="{{ __('Male') }}" {{ ($editData->gender == "Female" ? "selected": "") }}>{{ __('Female') }}</option>
                                </select>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="col-8">
                            <div class="mb-3">
                                <label for="billing-address" class="form-label">{{ __('Local address') }}</label>
                                <input class="form-control" name="adresse" value="{{ $editData->adresse }}" type="text" placeholder="{{ __('Local address') }}" id="billing-address">
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="mb-3">
                                <label for="billing-address" class="form-label">{{ __('Personal picture') }}</label>
                                <input name="photo" class="form-control" type="file" id="image">
                            </div>
                        </div>
                        <div class="col-1">
                            <div class="mb-3">
                                <img id="VoirImage" class="img-fluid avatar-lg rounded" src="{{ (!empty($editData->photo))? url('upload/admin_images/'.$editData->photo):url('upload/no_image.png') }}" alt="{{ __('Personal picture') }}">
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="text-center mt-sm-0 mt-3 text-sm-end">
                        <input type="submit" class="btn btn-info waves-effect waves-light" value="{{ __('Update profile') }}">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> <!-- end row-->
<script type="text/javascript">
$(document).ready(function() {
    $('#image').change(function(e) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#VoirImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });
});

</script>
@endsection
