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

        <button id="add-signature-pad" class="btn btn-success mb-2">{{ __('documents.add_signature') }}</button>
        <div id="signature-pads-container"></div>

        <form id="signature-form" method="POST" action="{{ route('admin.user_management.store_signature') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
           
            <button type="submit" class="btn btn-primary">{{ __('documents.save_all_signatures') }}</button>
            @error('user_id')
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
        const existingPad = document.querySelector('.signature-pad-container');
        if (existingPad) {
            existingPad.remove(); 
        }

        const padContainer = document.createElement('div');
        padContainer.classList.add('signature-pad-container');

        const canvas = document.createElement('canvas');
        canvas.width = 400;
        canvas.height = 200;
        canvas.style.border = '1px solid #000';

        const clearButton = document.createElement('button');
        clearButton.textContent = "{{ __('dashboard.clear') }}";
        clearButton.classList.add('btn', 'btn-danger', 'm-1');
        clearButton.addEventListener('click', () => {
            signaturePad.clear();
            inputElement.value = '';
        });

        padContainer.appendChild(canvas);
        padContainer.appendChild(clearButton);
        document.getElementById('signature-pads-container').appendChild(padContainer);

        const signaturePad = new SignaturePad(canvas);

        const inputElement = document.querySelector('input[name="signatures[]"]') || document.createElement('input');
        inputElement.type = 'hidden';
        inputElement.name = 'signatures[]';

        // إذا كان الإدخال غير موجود بالفعل، يتم إضافته
        if (!inputElement.parentNode) {
            document.getElementById('signature-form').appendChild(inputElement);
        }

        signaturePad.onEnd = () => {
            inputElement.value = signaturePad.toDataURL('image/png');
        };
    }
</script>

@endsection
