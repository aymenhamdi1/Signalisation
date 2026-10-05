@extends('template.admin_master')
@section('Content')
<script src="{{ asset('Backend/assets/js/jquery.min.js')}}"></script>
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <h4 class="page-title">{{ __('User') }}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('update.user',$editData->id) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="billing-first-name" class="form-label">{{ __('Name') }}</label>
                                <input class="form-control" name="name" value="{{$editData->name}}" type="text" placeholder="{{ __('Name') }}" id="billing-first-name" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="billing-last-name" class="form-label">{{ __('First Name') }}</label>
                                <input class="form-control" name="username" value="{{$editData->username}}" type="text" placeholder="{{ __('First Name') }}" id="billing-last-name" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="billing-phone" class="form-label">{{ __('Phone') }}<span class="text-danger">*</span></label>
                                <input class="form-control" name="phone" value="{{$editData->phone}}" type="text" placeholder="(xx) xxx xxxx xxx" id="billing-phone" />
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="billing-email-address" class="form-label">{{ __('Email') }}<span class="text-danger">*</span></label>
                                <input class="form-control" name="email" value="{{$editData->email}}" type="email" placeholder="{{ __('Email') }}" id="billing-email-address" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="billing-role" class="form-label">{{ __('role') }}</label>
                                <select class="form-select mb-3" name="role">
                                    <option selected>{{ __('Select Role') }}</option>
                                    @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ $editData->hasRole($role->name) ? 'selected' : '' }}>
                                        {{ __($role->name) }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="col-6">
                            <div class="mb-3">
                                <label for="billing-photo" class="form-label">{{ __('Personal picture') }}</label>
                                <input name="photo" value="{{$editData->photo}}" class="form-control" type="file" id="image">
                            </div>
                        </div>
                        <div class="col-2">
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <img id="VoirImage" class="img-fluid avatar-lg rounded" src="{{ (!empty($editData->photo))? url('upload/user_images/'.$editData->photo):url('upload/no_image.png') }}" alt="{{ __('Personal picture') }}" class="img-fluid avatar-sm rounded-circle shadow-sm">
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-3">
                                <input type="checkbox" id="switch4" data-switch="success" value="active" <?php if ($editData->status === "active") {echo "checked"; }?> id="1" name="status">
                                <label for="switch4" data-on-label="Oui" data-off-label="Non"></label>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="text-center mt-sm-0 mt-3 text-sm-end">
                        @if(Auth::user()->can('user.update'))
                        <input type="submit" class="btn btn-info waves-effect waves-light" value="{{ __('Update') }}">
                        @endif
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
