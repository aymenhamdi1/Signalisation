@extends('template.admin_master')
@section('Content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('Dashboard') }}</a></li>
                    <li class="breadcrumb-item"><a href="javascript: void(0);">{{ __('DBR') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('Permission') }} {{ __('By') }} {{ __('Role') }}</li>
                </ol>
            </div>
            <h4 class="page-title">{{ __('Permission') }} {{ __('By') }} {{ __('Role') }} </h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="text-center mt-sm-0 mt-3 text-sm-end">
            @if(Auth::user()->can('roles.permission.add'))
            <a href="{{ route('add.roles.permission') }}" class="btn btn-primary">
                <i class="mdi mdi-plus-circle"></i>{{ __('Add') }} {{ __('Permission') }} {{ __('By') }} {{ __('Role') }}
            </a>
            @endif
        </div>
        <div class="card">
            <div class="card-body">
                <h4 class="header-title">{{ __('Permission') }} {{ __('By') }} {{ __('Role') }} &ensp;&ensp;<span class="badge bg-success">{{count($roles)}}</span></h4>
                <div class="tab-content">
                    <div class="tab-pane show active" id="alt-pagination-preview">
                        <table id="datatable" class="table dt-responsive nowrap w-100">
                            <thead>
                                <tr>
                                    <th width="2%">{{ __('N°') }}</th>
                                    <th>{{ __('Role') }}</th>
                                    <th>{{ __('Permission') }}</th>
                                    <th width="10%">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $key=> $item)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    @php
    $colors = ['primary', 'secondary', 'success', 'danger', 'warning', 'info', 'dark']; // Liste des classes de couleur de Bootstrap
@endphp

<td>
    @forelse($item->permissions as $perm)
        @php
            $randomColor = $colors[array_rand($colors)]; // Sélectionner une couleur aléatoire
        @endphp
        <span class="badge rounded-pill bg-{{ $randomColor }}">{{ $perm->name }}</span>
    @empty
        <span class="badge bg-danger">{{ __('No') }} {{ __('Permission') }}</span>
    @endforelse
</td>

                                    <td>
                                        @if(Auth::user()->can('roles.permission.edit'))
                                        <a href="{{ route('permission.edit.roles',$item->id) }}" class="btn btn-soft-info"><i class="mdi mdi-shield-edit"></i>{{ __('Edit') }}</a>
                                        @endif
                                        @if(Auth::user()->can('roles.permission.delete'))
                                        <a href="{{ route('permission.delete.roles',$item->id) }}" class="btn btn-soft-danger" id="delete"><i class="mdi mdi-delete"></i>{{ __('Delete') }}</a>
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
@endsection
