@extends('layouts.dashboard')

@section('title')
    {{ __('documents.files') }}
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
    <div class="m-2 d-inline">
        <a href="{{ route('documents.create') }}"
            class="btn btn-sm btn-outline-primary mr-2 mb-4">{{ __('documents.add_document') }}</a>
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
                            <a href="{{ route('documents.show', $document->id) }}" class="btn btn-outline-info btn-sm"
                                title="@lang('dashboard.show')" target="_blank"><i class="fa fa-eye"></i></a>
                            <a href="{{ route('departments.delete', $document->id) }}" class="btn btn-danger btn-sm"
                                title="@lang('dashboard.delete')"><i class="fa fa-trash"></i></a>
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
    {{-- <script>
        // Select all bulk checkboxes
        $('.bulk_check_all').on('change', function() {
            $('.check_bulk_item').prop('checked', $(this).prop('checked'));
        });

        // Capture selected document IDs on clicking Add to Department button
        $('.docs').on('click', function(e) {
            e.preventDefault();

            // Collect all checked document IDs
            let selectedIds = [];
            $('.check_bulk_item:checked').each(function() {
                selectedIds.push($(this).val());
            });

            // Set the IDs into the hidden input in the modal
            $('#document_ids').val(selectedIds.join(','));
        });
    </script> --}}
    {{-- <script>
    $(document).on('click', '.docs', function(e) {
        e.preventDefault();
        var document_id = $(this).data('excel_id');
        $('#department_id').val(document_id);
    });
</script> --}}
@endsection
