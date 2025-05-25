@extends('layouts.dashboard')
@section('title')
<?php $lang = Session::get('locale'); ?>

    {{ __('roles.user_managment') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.user_managment') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard') }}">{{ __('dashboard.home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    {{-- @if (session()->has('locale'))
    {{ dd(session()->get('locale') ) }}
@endif --}}

    <form action="" method="get">

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="input-group mb-3 d-flex justify-content-end">
                        @can('change_users_status')
                            <div class="remv_control mr-2">
                                <select name="status" class="mr-3 mt-3 form-control ">
                                    <option value="">{{ __('dashboard.set_status') }}</option>
                                    <option value="1">{{ __('dashboard.active') }}</option>
                                    <option value="2">{{ __('dashboard.disactive') }}</option>
                                </select>
                            </div>
                        @endcan
                        @can('change_users_role')
                            <div class="remv_control mr-2">
                                <select name="role" class="mr-3 mt-3 form-control">
                                    <option value="">{{ __('roles.set_role') }}</option>
                                    <option value="1">{{ __('roles.user') }}</option>
                                    <option value="2">{{ __('roles.admin') }}</option>
                                </select>
                            </div>
                        @endcan
                        {{-- <a href="{{route('offer_create')}}" class="btn btn-primary mt-3 mr-2" data-toggle="tooltip" title="@lang('admin.offer_add')"> <i class="la la-plus"></i> </a> --}}


                        <button type="submit" name="bulk_action_btn" value="update_status"
                            class="btn btn-primary mt-3 mr-2">
                            <i class="la la-refresh"></i> {{ __('dashboard.update') }}
                        </button>

                        <button type="submit" name="bulk_action_btn" value="delete"
                            class="btn btn-danger delete_confirm mt-3 mr-2"> <i class="la la-trash"></i>
                            {{ __('dashboard.delete') }}</button>
                        <a href="{{ route('admin.user_managment.create') }}" class="btn btn-secondary mt-3 mr-2">
                            <i class="la la-refresh"></i> {{ ($lang == 'ar') ? "اضافة مستخدم" : "Create User" }}
                        </a>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th><input class="bulk_check_all" type="checkbox" /></th>
                            <th class="text-center" scope="col">{{ __('roles.name') }}</th>
                            <th class="text-center" scope="col">@lang('roles.status')</th>
                            <th class="text-center" scope="col">@lang('roles.role_name')</th>
                            <th class="text-center" scope="col">{{ __('roles.email') }}</th>
                            <th class="text-center" scope="col">{{ ($lang == 'ar') ? 'التوقيع' : "Signature" }}</th>
                            <th class="text-center" scope="col">{{ __('roles.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <th scope="row">
                                    <label>
                                        <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                            value="{{ $user->id }}" />
                                        <span class="text-muted">#{{ $user->id }}</span>
                                    </label>
                                </th>
                                <td class="text-center">{{ $user->name }}</td>
                                <td class="text-center"> <span
                                        class="badge badge-pill {{ $user->status == 'active' ? 'badge-success' : 'badge-danger' }}">{{ $user->status }}</span>
                                </td>
                                <td class="text-center">{{ $user->role_name }} </td>
                                <td class="text-center">{{ $user->email ?? $user->user_name }}</td>
                                <td class="text-center">
                                    @if($user->signature)<img src="{{ $user->signature  }}" width="80" height="80" alt="">
                                    @else
                                    {{ "لا يوجد" }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if (Auth::user()->role_id == 2)
                                        <a href="{{ route('admin.user_managment.delete', $user->id) }}"
                                            class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i
                                                class="fa fa-trash"></i></a>
                                    @endif
                                    @if (Auth::user()->role_id == 2)
                                        <a href="{{ route('admin.user_managment.edit', $user->id) }}"
                                            class="btn btn-outline-info btn-sm" title="@lang('dashboard.edit')"><i
                                                class="mdi mdi-pencil"></i> </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                        @endforelse


                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </form>


    @if (Session::has('success'))
        <script>
            swal("Message", "{{ Session::get('success') }}", 'success', {
                button: true,
                button: "Ok",
                timer: 3000,
            })
        </script>
    @endif
    @if (Session::has('info'))
        <script>
            swal("Message", "{{ Session::get('info') }}", 'info', {
                button: true,
                button: "Ok",
                timer: 3000,
            })
        </script>
    @endif
@endsection
