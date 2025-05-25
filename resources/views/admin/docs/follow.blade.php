@extends('layouts.dashboard')

@section('title')
    <?php
    $current_url = url()->current();
    $url = explode('/', $current_url);
    $end_url = end($url);
    $lang = Session::get('locale');
    ?>
    {{ $lang == 'ar' ? 'تتبع ملف' : 'Follow File' }}
@endsection


@section('page_name')
    {{ __('documents.files') }}
@endsection
@section('css')
@endsection
@section('content')
    {{-- <div class="page-breadcrumb">
        <div class="row">
            <div class="col-5 align-self-center">
                <h4 class="page-title">{{ __('documents.file') . ' : ' . $docs->name }}</h4>
                <hr>
                <h4 class="page-title">{{ __('documents.createdby') . ' : ' . $docs->owners->name }}
                </h4>
                <h4>{{ __('documents.atdate') . '   :   ' }}{{ $docs->created_at }}</h4>



                <h4>
                    {{ __('documents.sendto') . ' : ' }}
                    <hr>
                </h4>
                @foreach ($docs->departments as $item)
                    <h4 class="page-title">
                        {{ $item->name }}
                    </h4>
                    <h4>{{ __('documents.atdate') . '   :   ' }} {{ $item->created_at }}</h4>

                    <hr>
                @endforeach
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
    </div> --}}
    <div class="text-center mb-4">
        <h2>{{ $docs->name }}</h2>
    </div>

    {{-- أول عملية --}}
    <div class="d-flex justify-content-center align-items-center mb-4">
        <div style="border: 1px solid #000; padding: 10px; margin-left: 15px;">
            <strong>{{ __('documents.date') }}</strong><br>
            {{ $docs->created_at->format('Y-m-d') }}<br>
            <strong>{{ __('documents.time') }}</strong><br>
            {{ $docs->created_at->format('H:i') }}
        </div>

        <div style="background: linear-gradient(#aaa, #888); padding: 10px 30px; color: white; font-weight: bold;">
            {{ __('documents.created_by_user', ['name' => $docs->owners->name]) }}
            <hr>
            {{ __('documents.indepartment') . $docs->departments->first()->name }}

        </div>
    </div>

    {{-- سهم --}}
    <div class="text-center mb-4">
        <span style="font-size: 40px;">⬇️</span>
    </div>

    {{-- باقي العمليات --}}
    {{-- @foreach ($docs->departments as $item) --}}
    @forelse ($docs->logs as $action)
        <?php $user_action = App\Models\User::find($action->user_id); ?>


        @if ($action->action == 'شارك المستند')
            @foreach ($docs->departments->skip(1) as $item)
                <div class="d-flex justify-content-center align-items-center mb-4">

                    <div style="border: 1px solid #000; padding: 10px; margin-left: 15px;">
                        <strong>{{ __('documents.date') }}</strong><br>
                        {{ $action->created_at->format('Y-m-d') }}<br>
                        <strong>{{ __('documents.time') }}</strong><br>
                        {{ $action->created_at->format('H:i') }}
                    </div>


                    <div
                        style="background: linear-gradient(#aaa, #888); padding: 10px 30px; color: white; font-weight: bold;">
                        {!! clean_html($action->action) !!}
                        <div>{{ __('documents.sent_to_department', ['department' => $item->name]) }}</div>
                        <div>{{ $user_action->name }}</div>
                    </div>
                </div>


                <div class="text-center mb-4">
                    <span style="font-size: 40px;">⬇️</span>
                </div>
            @endforeach
        @elseif($action->action !== 'شارك المستند')
            <div class="d-flex justify-content-center align-items-center mb-4">
                <div style="border: 1px solid #000; padding: 10px; margin-left: 15px;">
                    <strong>{{ __('documents.date') }}</strong><br>
                    {{ $action->created_at->format('Y-m-d') }}<br>
                    <strong>{{ __('documents.time') }}</strong><br>
                    {{ $action->created_at->format('H:i') }}
                </div>

                <div style="background: linear-gradient(#aaa, #888); padding: 10px 30px; color: white; font-weight: bold;">
                    {!! clean_html($action->action) !!}
                    <div>{{ $user_action->name }}</div>
                </div>
            </div>

            <div class="text-center mb-4">
                <span style="font-size: 40px;">⬇️</span>
            </div>
        @endif
    @empty
        <tr>
            <td colspan="3">{{ __('No documents found') }}</td>
        </tr>
    @endforelse



    {{-- @endforeach --}}

    {{-- <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><input class="bulk_check_all" type="checkbox" /></th>
                    <th scope="col">{{ __('roles.Actions') }}</th>
                    <th scope="col"> {{ __('dashboard.edited_by') }}</th>

                </tr>
            </thead>
            <tbody>




                @forelse ($docs->logs as $action)
                    <?php $user_action = App\Models\User::find($action->user_id); ?>
                    <tr>

                        <td> {!! clean_html($action->action) !!}</td>
                        <td>

                            {{ $user_action->name }}
                        </td>
                        <td>

                            {{ $action->created_at->format('d-m-Y  ') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">{{ __('No documents found') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div> --}}
    {{-- @forelse ($docs->logs as $action)


<div class="d-flex justify-content-center align-items-center mb-4">
            <div style="border: 1px solid #000; padding: 10px; margin-left: 15px;">
                <strong>{{ __('documents.date') }}</strong><br>
                {{ $item->created_at->format('Y-m-d') }}<br>
                <strong>{{ __('documents.time') }}</strong><br>
                {{ $item->created_at->format('H:i') }}
            </div>

            <div style="background: linear-gradient(#aaa, #888); padding: 10px 30px; color: white; font-weight: bold;">
                {!! clean_html($action->action) !!}
            </div>
        </div>

        <div class="text-center mb-4">
            <span style="font-size: 40px;">⬇️</span>
        </div>
    </div>
  @endforelse --}}


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
