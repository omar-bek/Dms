@extends('layouts.dashboard')

@section('title')
    {{ __('documents.signatures') }}
@endsection
@section('css')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@2.3.2/dist/signature_pad.min.js"></script>
@endsection

@section('page_name')
    {{ __('roles.all_roles') }}
@endsection
@section('content')
<?php $user = Auth::user(); ?>
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('documents.signatures') }}</h4>
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
        @if (isset($user->signature))
            <p >{{ 'سيتم اضافة توقيعك الخاص تلقائيا' }}</p>
        @else
        <button id="add-signature-pad" class="btn btn-success mb-2">{{ __('documents.add_signature') }}</button>
        @endif
        <div id="signature-pads-container"></div>

        <form id="signature-form" method="POST" action="{{ route('save.signatures') }}">
            @csrf
            <input type="hidden" name="document_id" value="{{ $document->id }}">
            @if ($document->owners->id != $user->id )
            <div class="form-group">
                <label for="">ملاحظات</label>
                <textarea class="form-control" name="notes"  cols="30" rows="5"></textarea>
            </div>
            @else
            @endif
            <button type="submit" class="btn btn-primary">{{ __('documents.save_all_signatures') }}</button>
            @error('document_id')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
            @error('signatures')
                <span class="error text-danger">{{ $message }}</span>
            @enderror
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
    <script>
        document.getElementById('add-signature-pad').addEventListener('click', () => {
            createSignaturePad();
        });

        function createSignaturePad() {
            // إنشاء عنصر الـ div لاحتواء الـ Signature Pad
            const padContainer = document.createElement('div');
            padContainer.classList.add('signature-pad-container');

            // إنشاء الـ canvas لـ Signature Pad
            const canvas = document.createElement('canvas');
            canvas.width = 400;
            canvas.height = 200;
            canvas.style.border = '1px solid #000';

            // زر لمسح التوقيع
            const clearButton = document.createElement('button');
            clearButton.textContent = "{{ __('dashboard.clear') }}";
            clearButton.classList.add('btn', 'btn-danger', 'm-1');
            clearButton.addEventListener('click', () => {
                signaturePad.clear();
                inputElement.value = '';
            });

            const deleteButton = document.createElement('button');
            deleteButton.textContent = "{{ __('dashboard.delete') }}";
            deleteButton.classList.add('btn', 'btn-warning');
            deleteButton.addEventListener('click', () => {
                padContainer.remove();
            });

            padContainer.appendChild(canvas);
            padContainer.appendChild(clearButton);
            padContainer.appendChild(deleteButton);
            document.getElementById('signature-pads-container').appendChild(padContainer);

            const signaturePad = new SignaturePad(canvas);

            const inputElement = document.createElement('input');
            inputElement.type = 'hidden';
            inputElement.name = 'signatures[]';

            document.getElementById('signature-form').appendChild(inputElement);

            // تحديث الحقل المخفي ببيانات التوقيع عند كل تغيير
            signaturePad.onEnd = () => {
                inputElement.value = signaturePad.toDataURL('image/png');
            };
        }
    </script>
@endsection
