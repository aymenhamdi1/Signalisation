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
                    <li class="breadcrumb-item active">{{ __('User') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('User') }}</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="text-center mt-sm-0 mt-3 text-sm-end">
            @if(Auth::user()->can('user.add'))
            <a href="{{ route('add.user') }}" class="btn btn-primary">
                <i class="mdi mdi-plus-circle"></i>{{ __('Add') }} {{ __('User') }}
            </a>
            @endif
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('User') }} &ensp;&ensp;<span class="badge bg-success">{{count($alldata)}}</span></h4>
                <div class="tab-content">
                    <div class="tab-pane show active" id="alt-pagination-preview">
                        <table id="alternative-page-datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th width="2%">{{ __('N°') }}</th>
                                    <th>{{ __('name') }} </th>
                                    <th>{{ __('email') }} </th>
                                    <th>{{ __('Password') }} </th>
                                    <th>{{ __('Role') }} </th>
                                    <th>{{ __('status') }} </th>
                                    <th>{{ __('last active at') }} </th>
                                    <th width="10%">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alldata as $key => $user )
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $user->name }} {{ $user->username }}</td>
                                    <td> {{ $user->email }}</td>
                                    <td> {{ $user->code }}</td>
                                    <td> @foreach($user->roles as $role) {{ $role->name }} @endforeach</td>
                                    <td>
                                        <div class="mb-3">
                                            <input type="checkbox" id="switch4{{$user->id}}" class="status-checkbox form-check-input" data-switch="success" value="active" {{ $user->status === "active" ? "checked" : "" }} name="status" data-user-id="{{ $user->id }}">
                                            <label for="switch4{{$user->id}}" data-on-label="Oui" data-off-label="Non"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="last-active-container" data-user-id="{{ $user->id }}">
                                            @if($user->OnlineUser())
                                            <span class="badge badge-success-lighten">{{ __('Online') }}</span>
                                            @elseif(is_null($user->last_active_at))
                                            <span class="badge badge-secondary-lighten">{{ __('You are not logged in yet') }}</span>
                                            @elseif($user->last_active_at ==="2000-01-01 00:00:00")
                                            <span class="badge badge-danger-lighten">{{ __('Offline') }}</span>
                                            @else
                                            <span class="badge badge-info-lighten">{{ __('Last activity since: ') }}{{ Carbon\Carbon::parse($user->last_active_at)->diffForHumans() }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if(Auth::user()->can('user.edit'))
                                        <a href="{{ route('edit.user',$user->id) }}" class="btn btn-soft-info"><i class="mdi mdi-shield-edit"></i>{{ __('Edit') }}</a>
                                        @endif
                                        @if(Auth::user()->can('delete.add'))
                                        <a href="{{ route('delete.user',$user->id) }}" class="btn btn-soft-danger" id="delete"><i class="mdi mdi-delete"></i>{{ __('Delete') }}</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end preview-->
                </div> <!-- end tab-content-->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div> <!-- end row-->

<div class="row">
    <div class="card">
        <div class="card-body">
            <h4 class="header-title">{{ __('Delete') }} {{ __('User') }} &ensp;&ensp;<span class="badge bg-success">{{count($trachuser)}}</span></h4>
            <div class="tab-content">
                <div class="tab-pane show active" id="alt-pagination-preview">
                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th width="2%">{{ __('N°') }}</th>
                                <th>{{ __('name') }} </th>
                                <th>{{ __('email') }} </th>
                                <th>{{ __('Password') }} </th>
                                <th>{{ __('Role') }} </th>
                                <th>{{ __('status') }} </th>
                                <th>{{ __('last active at') }} </th>
                                <th width="12%">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trachuser as $key => $user )
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $user->name }} {{ $user->username }}</td>
                                <td> {{ $user->email }}</td>
                                <td> {{ $user->code }}</td>
                                <td> @foreach($user->roles as $role) {{ ($role->name) }} @endforeach</td>
                                <td>
                                    <div class="mb-3">
                                        <input type="checkbox" id="switch4{{$user->id}}" class="status-checkbox form-check-input" data-switch="success" value="active" {{ $user->status === "active" ? "checked" : "" }} name="status" data-user-id="{{ $user->id }}">
                                        <label for="switch4{{$user->id}}" data-on-label="Oui" data-off-label="Non"></label>
                                    </div>
                                </td>
                               
                                <td>
                                    <div class="last-active-container" data-user-id="{{ $user->id }}">
                                        @if($user->OnlineUser())
                                        <span class="badge badge-success-lighten">{{ __('Online') }}</span>
                                        @elseif(is_null($user->last_active_at))
                                        <span class="badge badge-secondary-lighten">{{ __('You are not logged in yet') }}</span>
                                        @elseif($user->last_active_at ==="2000-01-01 00:00:00")
                                        <span class="badge badge-danger-lighten">{{ __('Offline') }}</span>
                                        @else
                                        <span class="badge badge-info-lighten">{{ __('Last activity since: ') }}{{ Carbon\Carbon::parse($user->last_active_at)->diffForHumans() }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if(Auth::user()->can('user.restore'))
                                    <a href="{{ route('restore.user',$user->id) }}" class="btn btn-soft-primary" id="restore"><i class="mdi mdi-delete-restore"></i>{{ __('Restore') }}</a>
                                    @endif
                                    @if(Auth::user()->can('user.fdelete'))
                                    <a href="{{ route('forcedelete.user',$user->id) }}" class="btn btn-danger" id="pdelete"><i class="mdi mdi-delete-forever"></i>{{ __('Delete') }}</a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end preview-->
            </div> <!-- end tab-content-->
        </div> <!-- end card body-->
    </div> <!-- end card -->
</div><!-- end col-->
</div> <!-- end row-->

<script>
    $(document).ready(function() {
        $('.status-checkbox').change(function() {
            var userId = $(this).data('user-id');
            var status = $(this).is(':checked') ? 'active' : 'inactive';

            // Send Ajax request to update user status
            $.ajax({
                url: '{{ route("changestatus.user") }}', // Replace with the route URL for your changeStatus function
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}', // Add CSRF token if using Laravel
                    user_id: userId,
                    status: status
                },
                success: function(response) {
                    Swal.fire({
                    icon: response['alert-type'],
                    title: response['message'],
                    timer: 900,
            showConfirmButton: false,
            toast: true,
      position: 'center',
                });
                },
                error: function(xhr) {
                    Swal.fire({
                    icon: response['alert-type'],
                    title: response['message'],
                    timer: 900,
            showConfirmButton: false,
            toast: true,
      position: 'center',
                });
                }
            });
        });
    });
</script>
<script>
    setInterval(function() {
        // Iterate over each user row
        $('.last-active-container').each(function() {
            var userId = $(this).data('user-id');
            var container = $(this);
    
            $.ajax({
                url: "{{ route('getlastactive.user') }}",
                method: "GET",
                data: {
                    user_id: userId
                },
                success: function(response) {
                    var lastActive = response.last_active;
                    container.html(lastActive);
                },
                error: function() {
                    console.log('Error occurred while retrieving last active data.');
                }
            });
        });
    }, 60000); // 1-second interval
    </script>

@endsection
