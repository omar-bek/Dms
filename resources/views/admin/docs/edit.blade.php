@extends('layouts.dashboard')

@section('title')
    <?php $lang = Session::get('locale'); ?>

    {{ $lang == 'ar' ? 'تعديل مستند' : 'Edit Docs' }}
@endsection
@section('css')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
@endsection


@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title"> {{ $lang == 'ar' ? 'تعديل مستند' : 'Edit Docs' }}

                </h4>
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

    <div class="mb-5"></div>
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <form action="{{ route('documents.update', $document->id) }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">{{ __('roles.name') }}</label>
                                <input type="text" name="name" class="form-control" value="{{ $document->name }}">
                            </div>
                            <div class="form-group">
                                <label for="">{{ __('departments.departments') }}</label>
                                <select name="department_id[]" id="" class="form-control select2"
                                    multiple="multiple">
                                    <option value="">{{ __('departments.select_department') }}</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $document->departments->contains('id', $department->id) ? 'selected' : '' }}>
                                            {{ $department->name }}</option>
                                    @endforeach
                                    {{-- {{ ($department->inputs) ? selected($department->inputs->contains($input->id))  : '' }}>{{ $input->title_ar }} --}}
                                </select>
                            </div>
                            <h4 class="card-title">{{ __('documents.content') }}</h4>

                            <textarea id="mymce" name="contents"> {!! $document->content !!}</textarea>
                            <div style="display: flex; justify-content: space-between; flex-wrap: wrap;margin-top:30px">
                                @foreach ($document->signature as $signature)
                                    <div style="text-align: center; width: 48%;">
                                        <h4>{{ App\Models\User::where('id', $signature->user_id)->first()->name }}</h4>
                                        <img width="100px" height="100px" src="{{ $signature->image }}" alt="Signature">
                                    </div>
                                @endforeach
                            </div>
                            <div class="form-group mt-2"
                                style="text-align: {{ Session::get('locale') == 'en' ? 'right;margin-right:10px' : 'left;margin-left:10px' }}">
                                <button type="submit" class="btn btn-primary mt-2">{{ __('dashboard.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>

    <!-- This Page JS -->
    <script src="{{ asset('assets/libs/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/libs/tinymce/themes/modern/theme.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            if ($("#mymce").length > 0) {
                tinymce.init({
                    selector: "textarea#mymce",
                    theme: "modern",
                    height: 300,
                    plugins: [
                        "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                        "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                        "save table contextmenu directionality emoticons template paste textcolor"
                    ],
                    toolbar: "insertfile undo redo | styleselect | bold italic | fontselect fontsizeselect | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
                    fontsize_formats: '8pt 10pt 12pt 14pt 16pt 18pt 24pt 36pt',
                    font_formats: 'AlMohanad=AlMohanad, sans-serif; Arial=arial,helvetica,sans-serif; Times New Roman=times new roman,times,serif;',
                    content_style: "@import url('{{ asset('css/tinymce-custom.css') }}'); body { font-family: 'AE_AlMohanad', sans-serif; }"

                });
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "اختر العناصر",
                allowClear: true
            });
        });
    </script>
@endsection
