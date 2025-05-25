@extends('layouts.dashboard')

@section('title')
    <?php $lang = Session::get('locale'); ?>

    <?php
    $current_url = url()->current();
    $url = explode('/', $current_url);
    $end_url = end($url);
    
    ?>
    {{ $end_url == 'archive' ? __('dashboard.main_archive') : __('documents.files') }}
@endsection


@section('page_name')
    {{ __('documents.files') }}
@endsection
@section('css')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('documents.files') }}</h4>
                <div class="d-flex align-items-center">

                </div>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex no-block justify-content-end align-items-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="#">{{ __('dashboard.home') }} </a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('dashboard.dashboard') }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <form action="" method="get">
        @if ($end_url != 'archive')
            @can('create_documents')
                <div class="m-2 d-inline">
                    <a href="{{ route('documents.create') }}"
                        class="btn btn-sm btn-outline-primary mt-2 mr-2 mb-4">{{ __('documents.add_document') }}</a>
                </div>
            @endcan
        @endif
        <div class="remv_control mr-2 d-flex align-items-center">
            <input type="text" name="search" class="mr-3 mt-3 mb-2 form-control" placeholder="ابحث ...."
                style="width: 250px;">
            <button class="btn btn-sm btn-outline-primary mt-3 mb-2 mt-2" name="bulk_action_btn" value="search"
                type="submit">
                {{ $lang == 'ar' ? 'ابحث' : 'Search' }}
            </button>
        </div>
        <div class="remv_control mr-2 d-flex align-items-center">
            <select name="filter" class="mr-3 mt-3 mb-2 form-control" style="width: 250px;">
                <option value="1">{{ $lang == 'ar' ? 'فلترة بتاريخ الانشاء' : 'Filter By Created Date' }}</option>
                <option value="2">{{ $lang == 'ar' ? 'فلترة بتاريخ اخر تحديث' : 'Filter By Last Update Date' }}
                </option>
            </select>
            {{-- <input type="text" name="filter" class="mr-3 mt-3 mb-2 form-control"  > --}}
            <button class="btn btn-sm btn-outline-primary mt-3 mb-2 mt-2" name="bulk_action_btn" value="filter"
                type="submit">
                {{ $lang == 'ar' ? 'فلترة البيانات' : 'Filter' }}
            </button>
        </div>




        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><input class="bulk_check_all" type="checkbox" /></th>
                        <th scope="col">{{ __('roles.name') }}</th>
                        <th scope="col">{{ __('roles.createby') }}</th>
                        {{-- <th scope="col">{{ __('roles.shareby') }}</th> --}}
                        <th scope="col">{{ __('roles.Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($documents as $document)
                        <tr>
                            <th scope="row">
                                <label>
                                    <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                        value="{{ $document->id }}" />
                                    <span class="text-muted">#{{ $document->id }}</span>
                                </label>
                            </th>
                            <td>{{ $document->name }}</td>
                            <td>{{ $document->owners->name }}</td>
                            {{-- <td>{{ $document->sender->name }}</td> --}}
                            <td>

                                @can('show_documents')
                                    <a href="{{ route('documents.show', $document->id) }}" class="btn btn-outline-info btn-sm"
                                        title="@lang('dashboard.show')"><i class="mdi mdi-monitor"></i></a>
                                @endcan
                                @can('delete_documents')
                                    <a href="{{ route('documents.delete', $document->id) }}" class="btn btn-danger btn-sm"
                                        title="@lang('dashboard.delete')"><i class="fa fa-trash"></i></a>
                                @endcan

                                @if ($end_url == 'archive')
                                    @can('delete_from_archive')
                                        <a href="{{ route('documents.delete_archive', $document->id) }}"
                                            class="btn btn-success btn-sm" title="@lang('dashboard.delete_archive')"><i
                                                class="mdi mdi-archive"></i></a>
                                    @endcan
                                @else
                                    @can('moved_to_archive')
                                        <a href="{{ route('documents.archive', $document->id) }}"
                                            class="btn btn-success btn-sm" title="@lang('dashboard.archive')"><i
                                                class="mdi mdi-archive"></i></a>
                                    @endcan
                                @endif
                                @can('share_with_departments')
                                    <a href="" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-section_id="{{ $document->id }}" title="@lang('dashboard.share')"
                                        data-target="#delete_section"><i class="mdi mdi-share"></i></a>
                                @endcan
                                @can('follow_document')
                                    <a href="{{ route('documents.follow', $document->id) }}"
                                        class="btn btn-outline-info btn-sm" title="@lang('dashboard.follow')"><i class="fa fa-eye"></i>
                                    </a>
                                @endcan
                                @can('edit_documents')
                                    <a href="{{ route('documents.edit', $document->id) }}" class="btn btn-outline-info btn-sm"
                                        title="@lang('dashboard.edit')"><i class="mdi mdi-pencil"></i> </a>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">{{ __('No documents found') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </form>
    <div class="modal fade" id="delete_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('dashboard.share') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('add_to_department') }}" method="post">
                    @csrf

                    <div class="modal-body">
                        <input type="hidden" name="document_id" id="delete_section" value="">
                        <div class="form-group">
                            <label for="">{{ __('departments.departments') }}</label>
                            <select name="department_id[]" class="form-control select2" multiple="multiple">
                                <option value="">{{ __('departments.select_department') }}</option>
                                @foreach ($departments as $department)
                                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('dashboard.cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('dashboard.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>

    {!! $documents->links() !!}

    {{-- <div class="m-2 d-inline">
        <a href="" class="btn  btn-sm btn-outline-primary mr-2 mb-4"  data-excel_id=""
            data-toggle="modal" data-target="#excel_id">{{ __('documents.add_document') }}</a>
    </div> --}}
    {{-- <div class="modal fade" id="excel_id" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('documents.add_document') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('add_to_department') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <input type="text" name="department_id" value="">

                        <div class="form-group">
                            <label class="form-control" for="">{{ __('departments.departments') }}</label>
                            <select class="form-control select2 department_ids" name="department_ids[]" multiple="multiple">
                                <option value="0">{{ __('departments.departments') }}</option>
                                @foreach ($departments as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('department_ids')
                                <span class="error text-danger">{{ $message }}</span>
                            @enderror

                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">{{ __('dashboard.cancel') }}</button>
                        <button type="submit" class="btn btn-success">{{ __('dashboard.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="mb-5"></div>
    <form action="" method="get">

        <div class="col-12">
            <div class="card">
                <div class="input-group mb-3 d-flex justify-content-end">

                    <button type="submit" name="bulk_action_btn" value="delete"
                        class="btn btn-danger delete_confirm mt-3 {{ Session::get('locale') == 'en' ? 'mr-2' : 'ml-2' }}">
                        <i class="la la-trash"></i> {{ __('dashboard.delete') }}</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th><input class="bulk_check_all" type="checkbox" /></th>
                                <th scope="col">{{ __('roles.name') }}</th>
                                <th scope="col">{{ __('roles.Actions') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($documents as $document)
                                <tr>
                                    <th scope="row">
                                        <label>
                                            <input class="check_bulk_item" name="bulk_ids[]" type="checkbox"
                                                value="{{ $document->id }}" />
                                            <span class="text-muted">#{{ $document->id }}</span>
                                        </label>
                                    </th>

                                    <td>{{ $document->name }}</td>
                                    <td>

                                        <a href="{{ route('documents.show', $document->id) }}"
                                            class="btn btn-outline-info btn-sm" title="@lang('dashboard.show')" ><i
                                                class="fa fa-eye"></i> </a>
                                        <a href="{{ route('departments.delete', $document->id) }}"
                                            class="btn btn-danger btn-sm" title="@lang('dashboard.delete')"><i
                                                class="fa fa-trash"></i> </a>

                                    </td>
                                </tr>
                            @empty
                            @endforelse


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </form> --}}
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
    @if (Session::has('error'))
        <script>
            swal("Message", "{{ Session::get('error') }}", 'danger', {
                button: true,
                button: "Ok",
                timer: 3000,
            })
        </script>
    @endif
@endsection
@section('js')
    <script>
        $(".department_ids").select2({
            topics: true,
            tokenSeparators: [',', ' ']
        })
    </script>


    <script>
        $('#delete_section').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var section_id = button.data('section_id')
            var modal = $(this)
            modal.find('.modal-body #delete_section').val(section_id);
        })
    </script>
    <script>
        $(document).ready(function() {
            // تأكد من تفعيل select2 بعد فتح الـ modal
            $('#delete_section').on('shown.bs.modal', function() {
                $('.select2').select2({
                    dropdownParent: $('#delete_section'), // للتأكد من فتح القائمة داخل الـ modal
                    placeholder: "{{ __('departments.select_department') }}",
                    allowClear: true
                });
            });
        });
    </script>
@endsection
