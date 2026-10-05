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
                    <li class="breadcrumb-item active">{{ __('Add') }} {{ __('Permission') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('Add') }} {{ __('Permission') }}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('permission.update',$permission[0]->group_name) }}">
                    
                    @csrf
                    <div class="add_item">
                        @foreach($permission as $edit)
                        <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
                            <div class="row mb-12">
                                <div class="col-sm-5 form-group">
                                    <label>{{ __('Group') }} {{ __('Permission') }}</label>
                                    <input name="group_name[]" class="form-control" id="group_name" value="{{ $edit->group_name }}" placeholder="{{ __('Group') }} {{ __('Permission') }}">
                                    @error('group_name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label>{{ __('Name') }} {{ __('Permission') }}</label>
                                    <input name="name[]" class="form-control" id="name" value="{{ $edit->name }}" placeholder="{{ __('Name') }} {{ __('Permission') }}">
                                    @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-sm-1" style="padding-top: 25px;">
                                    @if(Auth::user()->can('permission:permission.store'))
                                    <span class="btn btn-success addeventmore"><i class="mdi mdi-plus-circle"></i> </span>
                                    <span class="btn btn-danger removeeventmore"><i class="mdi mdi-minus-circle"></i> </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <br>
                    <!-- end row -->
                    <br>
                    @if(Auth::user()->can('permission:permission.store'))
                    <button type="submit" class="btn btn-info float-end">{{ __('Save') }}</button>
                    @endif
                </form>
            </div>
        </div>
    </div> <!-- end col -->
</div>
<div style="visibility: hidden;">
    <div class="whole_extra_item_add" id="whole_extra_item_add">
        <div class="delete_whole_extra_item_add" id="delete_whole_extra_item_add">
            <div class="add_item">
                <div class="row mb-12">
                    <div class="col-sm-5 form-group">
                        <label>{{ __('Group') }} {{ __('Permission') }}</label>
                        <input name="group_name[]" class="form-control" id="group_name" placeholder="{{ __('Group') }} {{ __('Permission') }}">
                        @error('group_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-6 form-group">
                        <label>{{ __('Name') }} {{ __('Permission') }}</label>
                        <input name="name[]" class="form-control" id="name" placeholder="{{ __('Name') }} {{ __('Permission') }}">
                        @error('name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-sm-1" style="padding-top: 25px;">
                        <span class="btn btn-success addeventmore"><i class="mdi mdi-plus-circle"></i> </span>
                        <span class="btn btn-danger removeeventmore"><i class="mdi mdi-minus-circle"></i> </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var counter = 0;
    $(document).on("click", ".addeventmore", function() {
        var whole_extra_item_add = $('#whole_extra_item_add').html();
        $(this).closest(".add_item").append(whole_extra_item_add);
        counter++;
    });
    $(document).on("click", '.removeeventmore', function(event) {
        $(this).closest(".delete_whole_extra_item_add").remove();
        counter -= 1
    });

});

</script>
@endsection
