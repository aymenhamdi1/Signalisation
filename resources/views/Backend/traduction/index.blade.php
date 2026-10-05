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
                    <li class="breadcrumb-item active">{{ __('Language') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('Language') }}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        
        <div class="text-center mt-sm-0 mt-3 text-sm-end d-flex justify-content-between">
            <a href="{{ route('extract.translations') }}" class="btn btn-soft-warning">
                <i class="mdi mdi-plus-circle"></i>{{ __('Extract') }} {{ __('Language') }}
            </a>
            <a href="{{ route('add.traduction') }}" class="btn btn-soft-success">
                <i class="mdi mdi-plus-circle"></i>{{ __('Add') }} {{ __('Language') }}
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('Language') }} &ensp;&ensp;<span class="badge bg-success">{{ count($data) }}</span></h4>
                <div class="tab-content">
                    <div class="tab-pane show active" id="alt-pagination-preview">
                        <form action="{{ route('delete.multiple.traductions') }}" method="POST" id="deleteForm">
                            @csrf
                            <div class="mt-3">
                                <button type="submit" class="btn btn-outline-danger">{{ __('Delete Selected') }}</button><br><br>
                            </div>
                            <table id="alternative-page-datatable" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th width="2%"><input type="checkbox" class="form-check-input" id="selectall"></th>
                                        <th>{{ __('N°') }}</th>
                                        <th>{{ __('Key') }}</th>
                                        <th>{{ __('Languages') }}</th>
                                        <th>{{ __('Translation is available in three languages') }}</th>
                                        <th width="10%">{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $key => $item)
                                        <tr>
                                            <td><input type="checkbox" class="form-check-input" name="selectedItems[]" value="{{ $item['key'] }}"></td>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item['key'] }}</td>
                                            <td>{{ implode(', ', $item['languages']) }}</td>
                                            <td>
                                                <div class="progress mb-3" style="height: 10px;">
                                                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-{{ $item['color'] }}" role="progressbar" style="width: {{ count($item['languages']) * 33.33 }}%" aria-valuenow="{{ count($item['languages']) }}" aria-valuemin="0" aria-valuemax="3">{{ count($item['languages']) }}/3</div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('edit.traduction', $item['key']) }}" class="btn btn-soft-info"><i class="mdi mdi-shield-edit"></i>{{ __('Edit') }}</a>
                                                <a href="{{ route('delete.traduction', $item['key']) }}" class="btn btn-soft-danger" id="delete"><i class="mdi mdi-delete"></i>{{ __('Delete') }}</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            
                        </form>
                    </div> <!-- end preview-->
                </div> <!-- end tab-content-->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div> <!-- end row-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#selectall').click(function() {
            if ($(this).is(':checked')) {
                $('input[type=checkbox]').prop('checked', true);
            } else {
                $('input[type=checkbox]').prop('checked', false);
            }
        });
    });
    </script>
@endsection
