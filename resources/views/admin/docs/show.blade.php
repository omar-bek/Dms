@extends('layouts.dashboard')

@section('title')
    {{ __('documents.show_document') }}
@endsection

@section('css')
    <style>
        .custom-class {
            border: none;
            border-top: 2px solid #000;
            margin: 20px 0;
        }
    </style>
 
@endsection
@section('page_name')
    {{ __('roles.all_roles') }}
@endsection
@section('content')
    <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title"> {{ __('documents.show_document') }} </h4>
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
                            <li class="breadcrumb-item active" aria-current="page"> {{ __('documents.show_document') }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>


    <div class="mb-5"></div>
    <div class="col-md-12 mb-5">

        <div class="text-right">
            <a href="{{ route('signatures', $document->id) }}"
                class="btn btn-primary">{{ __('documents.add_signature') }}</a>
            <a href="{{ route('documents.print_pdf', $document->id) }}"
                class="btn btn-primary">{{ __('dashboard.print') }}</a>
            <!-- <button id="print" onclick="printDiv()" class="btn btn-default btn-outline" type="button"> <span><i
                        class="fa fa-print"></i>{{ __('dashboard.print') }}</span> </button> -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-body ">
                <h3><b>{{ $document->name }}</b> <span class="pull-right"></span></h3>
                <hr>
                <div class="row">
                    <style>
                        @import url('{{ asset('css/tinymce-custom.css') }}');

                        body {
                            font-family: 'AE_AlMohanad', sans-serif;
                        }
                    </style>
                    <div class="col-md-12 printableArea"
                        style="position: relative; min-height: 100vh; padding-bottom: 150px;">
                        {!! clean_html($document->content) !!}
                        @php
                            $signatureCount = $document->signature->count();
                        @endphp
                        @if ($document->signature->isNotEmpty())
                            <div @if($signatureCount == 1) dir="ltr" @endif
                            style="display: flex; justify-content: space-between; flex-wrap: wrap;margin-top:30px"
                                >
                                @foreach ($document->signature as $signature)
                                    <div style="text-align: center; width: 48%;">
                                        @if ($signature->notes != null)
                                            <p>{{ $signature->notes }}</p>
                                        @else
                                            <h4>{{ App\Models\User::where('id', $signature->user_id)->first()->name }}</h4>
                                        @endif

                                        <img width="100px"  height="100px" src="{{ $signature->image }}" alt="Signature">
                                       
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>


                    {{-- <div class="col-md-12 printableArea">
                        {!! clean_html($document->content) !!}
                        @if ($document->signature->isNotEmpty())
                        <div style="display: flex; justify-content: space-between; flex-wrap: wrap;margin-top:30px">
                            @foreach ($document->signature as $signature)
                                <div style="text-align: center; width: 48%;">
                                    <h4>{{ App\Models\User::where('id' , $signature->user_id)->first()->name }}</h4>
                                    <img width="100px" height="100px" src="{{ $signature->image }}" alt="Signature">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    </div> --}}

                    <div class="col-md-12">
                        <hr class="custom-class">
                        <div class="pull-right mt-5 {{ Session::get('locale') == 'en' ? 'text-right' : 'text-left' }}">
                            <address>
                                <h4 class="font-bold">{{ __('dashboard.created_by') }} : {{ $document->owners->name }}
                                </h4>

                                <p class="m-t-30"><b>{{ __('dashboard.created_at') }}</b> <i class="fa fa-calendar"></i>
                                    {{ $document->created_at->shortAbsoluteDiffForHumans() }}</p>
                            </address>
                        </div>
                    </div>


                </div>
            </div>
        </div>


    </div>

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
    <script src="{{ asset('dist/js/pages/samplepages/jquery.PrintArea.js') }}"></script>
    <script type="text/javascript">
        function printDiv() {
            var printContents = document.querySelector('.printableArea').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
    {{-- <script>
        $(function() {
            $("#print").click(function() {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };
                $("div.printableArea").printArea(options);
            });
        });
    </script> --}}
@endsection
