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
                    <li class="breadcrumb-item active">{{ __('Edit') }} {{ __('Permission') }} {{ __('By') }} {{ __('Role') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('Edit') }} {{ __('Permission') }} {{ __('By') }} {{ __('Role') }}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('role.permission.update',$role->id) }}">
                    @csrf
                    <div class="col-sm-6 form-group">
                        <label>{{ __('Role') }}</label>
                        <h3> {{ $role->name }} </h3>
                    </div>
                    <br>
                    <div class="form-check mb-2 form-check-primary">
                        <h5 class="font-size-14 mb-3">{{ __('All') }} {{ __('Permission') }}</h5>
                        <input data-switch="success" type="checkbox" value="" id="switch1All">
                        <label data-on-label="{{ __('Yes') }}" data-off-label="{{ __('No') }}" for="switch1All"></label>
                    </div>
                    <hr>
                    @foreach($permission_groups as $group)
                                    <div class="row">
                                        <div class="col-3">
                                            @php
                                            $permissions = App\Models\User::getpermissionByGroupName($group->group_name);
                                            @endphp
                                            <div class="form-check mb-2 form-switch mb-3 form-checkbox-success">
                                                <input class="form-check-input" type="checkbox" value="" id="customckeck1" {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : ''}}>
                                                <label class="form-check-label" for="customckeck1">{{ $group->group_name }}</label>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            @foreach($permissions as $permission)
                                            <div class="form-check mb-2 form-switch mb-3 form-checkbox-info">
                                                <input class="form-check-input" type="checkbox" name="permission[]" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }} value="{{ $permission->id }}" id="customckeck{{ $permission->id }}">
                                                <label class="form-check-label" for="customckeck{{ $permission->id }}">{{ $permission->name }}</label>
                                            </div>
                                            @endforeach
                                            <br>
                                        </div>
                                    </div> <!-- end row -->
                                    @endforeach
                    <div class="text-center mt-sm-0 mt-3 text-sm-end">
                        @if(Auth::user()->can('roles.permission.update'))
                        <button type="submit" class="btn btn-info float-end">{{ __('Edit') }}</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div> <!-- End col -->
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#switch1All').click(function() {
        if ($(this).is(':checked')) {
            $('input[type=checkbox]').prop('checked', true);
        } else {
            $('input[type=checkbox]').prop('checked', false);
        }
    });

    $('input[id^=customckeck1]').click(function() {
        var groupCheckbox = $(this);
        var groupPermissions = groupCheckbox.closest('.row').find('input[name="permission[]"]');

        if (groupCheckbox.is(':checked')) {
            // Check permissions belonging to the group
            groupPermissions.prop('checked', true);
        } else {
            // Uncheck permissions belonging to the group
            groupPermissions.prop('checked', false);
        }

        // Check if all groups are selected
        var allGroupsSelected = $('input[id^=customckeck1]').length === $('input[id^=customckeck1]:checked').length;
        if (allGroupsSelected) {
            // Check the "All Permissions" checkbox
            $('#switch1All').prop('checked', true);
        } else {
            // Uncheck the "All Permissions" checkbox
            $('#switch1All').prop('checked', false);
        }
    });

    $('input[name="permission[]"]').click(function() {
        var allPermissionsCheckbox = $('#switch1All');
        var groupCheckbox = $(this).closest('.row').find('input[id^=customckeck1]');

        if (!$(this).is(':checked')) {
            // Uncheck the "All Permissions" checkbox
            allPermissionsCheckbox.prop('checked', false);
        } else {
            // Check if all permissions are selected
            var allPermissionsSelected = $('input[name="permission[]"]').length === $('input[name="permission[]"]:checked').length;
            if (allPermissionsSelected) {
                // Check the "All Permissions" checkbox
                allPermissionsCheckbox.prop('checked', true);
            }
        }

        // Check if all permissions of the group are selected
        var groupPermissions = $(this).closest('.row').find('input[name="permission[]"]');
        var allGroupPermissionsSelected = groupPermissions.length === groupPermissions.filter(':checked').length;
        if (allGroupPermissionsSelected) {
            // Check the group checkbox
            groupCheckbox.prop('checked', true);
        } else {
            // Uncheck the group checkbox
            groupCheckbox.prop('checked', false);
        }
    });
});

</script>
@endsection
