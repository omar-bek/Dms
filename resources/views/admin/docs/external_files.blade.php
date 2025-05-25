@extends('layouts.dashboard')

@section('title')
    <?php
    $current_url = url()->current();
    $url = explode('/', $current_url);
    $end_url = end($url);
    $lang = Session::get('locale');
    ?>
    {{ __('roles.external_files') }}
@endsection


@section('page_name')
    {{ __('roles.external_files') }}
@endsection
@section('css')
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('roles.external_files') }}</h4>
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
    <div style="{{ ($lang == 'ar' ) ? "text-align: left;" : "text-align: right;" }}">
        @can('share_with_departments')
            <a href="" class="btn btn-primary btn-sm m-2" data-toggle="modal" data-section_id=" " title="@lang('dashboard.share')"
               data-target="#delete_section"> 
               {{ __('roles.uploadpdf') }}
            </a>
        @endcan
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

                            @can('show_documents')
                                <a href="{{ route('documents.view', $document->id) }}" class="btn btn-outline-info btn-sm"
                                    title="@lang('dashboard.show')" target="_blank"><i class="mdi mdi-monitor"></i></a>
                            @endcan
                            @can('delete_documents')
                                <a href="{{ route('documents.external_delete', $document->id) }}" class="btn btn-danger btn-sm"
                                    title="@lang('dashboard.delete')"><i class="fa fa-trash"></i></a>
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
    <div class="modal fade" id="delete_section" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{  __('roles.uploadpdf') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('documents.uploadPdf') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">{{ __('roles.name') }}</label>
                            <input type="text" name="name"  class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="">{{ __('documents.file') }}</label>

                            <input type="file" name="file"  class="form-control">

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
                                            class="btn btn-outline-info btn-sm" title="@lang('dashboard.show')" target="_blank"><i
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
