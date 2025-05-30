@extends('layouts.dashboard')

@section('title')
    {{ __('messages.messages') }}
@endsection


@section('page_name')
    {{ __('messages.all_messages') }}
@endsection
@section('content')
    <?php $lang = config('app.locale');
    $user = auth()->user();
    ?>

        <div class="left-part bg-light fixed-left-part  border-top">
            <!-- Mobile toggle button -->
            <a class="ti-menu ti-close btn btn-success show-left-part d-block d-md-none" href="javascript:void(0)"></a>
            <!-- Mobile toggle button -->
            <div class="p-15">
                <h4>Chat Sidebar</h4>
            </div>
            <div class="scrollable position-relative" style="height:100%;">
                <div class="p-15">
                    <h5 class="card-title">Search Contact</h5>
                    <form>
                        <input class="form-control" type="text" placeholder="Search Contact">
                    </form>
                </div>
                <hr>
                <ul class="mailbox list-style-none">
                    <li>
                        <div class="message-center chat-scroll">
                            <a href="javascript:void(0)" class="message-item" id='chat_user_1' data-user-id='1'>
                                <span class="user-img">
                                    <img src="{{ asset('assets/images/users/1.jpg') }}" alt="user" class="rounded-circle">
                                    <span class="profile-status online pull-right"></span>
                                </span>
                                <div class="mail-contnet">
                                    <h5 class="message-title">Pavan kumar</h5>
                                    <span class="mail-desc">Just see the my admin!</span>
                                    <span class="time">9:30 AM</span>
                                </div>
                            </a>
                            <!-- Message -->
                            <a href="javascript:void(0)" class="message-item" id='chat_user_2' data-user-id='2'>
                                <span class="user-img">
                                    <img src="{{ asset('assets/images/users/2.jpg') }}" alt="user" class="rounded-circle">
                                    <span class="profile-status busy pull-right"></span>
                                </span>
                                <div class="mail-contnet">
                                    <h5 class="message-title">Sonu Nigam</h5>
                                    <span class="mail-desc">I've sung a song! See you at</span>
                                    <span class="time">9:10 AM</span>
                                </div>
                            </a>
                            <!-- Message -->
                            <a href="javascript:void(0)" class="message-item" id='chat_user_3' data-user-id='3'>
                                <span class="user-img">
                                    <img src="{{ asset('assets/images/users/3.jpg') }}" alt="user" class="rounded-circle">
                                    <span class="profile-status away pull-right"></span>
                                </span>
                                <div class="mail-contnet">
                                    <h5 class="message-title">Arijit Sinh</h5>
                                    <span class="mail-desc">I am a singer!</span>
                                    <span class="time">9:08 AM</span>
                                </div>
                            </a>
                            <!-- Message -->
                            <a href="javascript:void(0)" class="message-item" id='chat_user_4' data-user-id='4'>
                                <span class="user-img">
                                    <img src="{{ asset('assets/images/users/4.jpg') }}" alt="user" class="rounded-circle">
                                    <span class="profile-status offline pull-right"></span>
                                </span>
                                <div class="mail-contnet">
                                    <h5 class="message-title">Nirav Joshi</h5>
                                    <span class="mail-desc">Just see the my admin!</span>
                                    <span class="time">9:02 AM</span>
                                </div>
                            </a>
                            <!-- Message -->
                            <!-- Message -->
                            <a href="javascript:void(0)" class="message-item" id='chat_user_5' data-user-id='5'>
                                <span class="user-img">
                                    <img src="../../assets/images/users/5.jpg" alt="user" class="rounded-circle">
                                    <span class="profile-status offline pull-right"></span>
                                </span>
                                <div class="mail-contnet">
                                    <h5 class="message-title">Sunil Joshi</h5>
                                    <span class="mail-desc">Just see the my admin!</span>
                                    <span class="time">9:02 AM</span>
                                </div>
                            </a>
                            <!-- Message -->
                            <!-- Message -->
                            <a href="javascript:void(0)" class="message-item" id='chat_user_6' data-user-id='6'>
                                <span class="user-img">
                                    <img src="../../assets/images/users/6.jpg" alt="user" class="rounded-circle">
                                    <span class="profile-status offline pull-right"></span>
                                </span>
                                <div class="mail-contnet">
                                    <h5 class="message-title">Akshay Kumar</h5>
                                    <span class="mail-desc">Just see the my admin!</span>
                                    <span class="time">9:02 AM</span>
                                </div>
                            </a>
                            <!-- Message -->
                            <!-- Message -->
                            <a href="javascript:void(0)" class="message-item" id='chat_user_7' data-user-id='7'>
                                <span class="user-img">
                                    <img src="../../assets/images/users/7.jpg" alt="user" class="rounded-circle">
                                    <span class="profile-status offline pull-right"></span>
                                </span>
                                <div class="mail-contnet">
                                    <h5 class="message-title">Pavan kumar</h5>
                                    <span class="mail-desc">Just see the my admin!</span>
                                    <span class="time">9:02 AM</span>
                                </div>
                            </a>
                            <!-- Message -->
                            <!-- Message -->
                            <a href="javascript:void(0)" class="message-item" id='chat_user_8' data-user-id='8'>
                                <span class="user-img">
                                    <img src="../../assets/images/users/8.jpg" alt="user" class="rounded-circle">
                                    <span class="profile-status offline pull-right"></span>
                                </span>
                                <div class="mail-contnet">
                                    <h5 class="message-title">Varun Dhavan</h5>
                                    <span class="mail-desc">Just see the my admin!</span>
                                    <span class="time">9:02 AM</span>
                                </div>
                            </a>
                            <!-- Message -->
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <div class="right-part  border-top">
            <div class="p-20">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Chat Messages</h4>
                        <div class="chat-box scrollable" style="height:calc(100vh - 300px);">
                            <!--chat Row -->
                            <ul class="chat-list">
                                <!--chat Row -->
                                <li class="chat-item">
                                    <div class="chat-img">
                                        <img src="{{ asset('assets/images/users/1.jpg') }}" alt="user">
                                    </div>
                                    <div class="chat-content">
                                        <h6 class="font-medium">James Anderson</h6>
                                        <div class="box bg-light-info">Lorem Ipsum is simply dummy text of the printing &amp; type setting industry.</div>
                                    </div>
                                    <div class="chat-time">10:56 am</div>
                                </li>
                                <!--chat Row -->
                                <li class="chat-item">
                                    <div class="chat-img">
                                        <img src="{{ asset('assets/images/users/2.jpg') }}" alt="user">
                                    </div>
                                    <div class="chat-content">
                                        <h6 class="font-medium">Bianca Doe</h6>
                                        <div class="box bg-light-info">It’s Great opportunity to work.</div>
                                    </div>
                                    <div class="chat-time">10:57 am</div>
                                </li>
                                <!--chat Row -->
                                <li class="odd chat-item">
                                    <div class="chat-content">
                                        <div class="box bg-light-inverse">I would love to join the team.</div>
                                        <br>
                                    </div>
                                </li>
                                <!--chat Row -->
                                <li class="odd chat-item">
                                    <div class="chat-content">
                                        <div class="box bg-light-inverse">Whats budget of the new project.</div>
                                        <br>
                                    </div>
                                    <div class="chat-time">10:59 am</div>
                                </li>
                                <!--chat Row -->
                                <li class="chat-item">
                                    <div class="chat-img">
                                        <img src="{{ asset('assets/images/users/3.jpg') }}" alt="user">
                                    </div>
                                    <div class="chat-content">
                                        <h6 class="font-medium">Angelina Rhodes</h6>
                                        <div class="box bg-light-info">Well we have good budget for the project</div>
                                    </div>
                                    <div class="chat-time">11:00 am</div>
                                </li>
                                <!--chat Row -->
                            </ul>
                        </div>
                    </div>
                    <div class="card-body border-top">
                        <div class="row">
                            <div class="col-9">
                                <div class="input-field m-t-0 m-b-0">
                                    <input id="textarea1" placeholder="Type and enter" class="form-control border-0" type="text">
                                </div>
                            </div>
                            <div class="col-3">
                                <a class="btn-circle btn-lg btn-cyan float-right text-white" href="javascript:void(0)">
                                    <i class="fas fa-paper-plane"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



@endsection