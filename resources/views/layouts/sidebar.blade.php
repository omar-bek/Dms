<aside class="left-sidebar mt-3">
    <!-- Sidebar scroll-->
    <?php $user = auth()->user();
        $lang = Session::get('locale');
    ?>
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->





                @can('user_management')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fa fa-users"></i>

                            <span class="hide-menu">{{ __('roles.user_management') }} </span>
                        </a>
                        @can('all_users')
                            <ul aria-expanded="false" class="collapse  first-level">
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.user_managment') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('roles.all_users') }}</span>
                                    </a>
                                </li>

                            </ul>
                        @endcan
                    </li>
                @endcan
                @can('Admin_Roles')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fa fa-id-badge"></i>


                            <span class="hide-menu">{{ __('roles.roles') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('Show_Admin_Roles')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.roles') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('roles.all_roles') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('Create_Admin_Roles')
                                <li class="sidebar-item">
                                    <a href="{{ route('admin.roles.create') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('roles.create_role') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('departments')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class="fas fa-tags nav-icon"></i>


                            <span class="hide-menu">{{ __('departments.departments') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('all_departments')
                                <li class="sidebar-item">
                                    <a href="{{ route('all_departments') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('departments.all_departments') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('create_department')
                                <li class="sidebar-item">
                                    <a href="{{ route('departments.create_department') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('departments.create_department') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('documents')
                    <li class="sidebar-item">
                        <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                            aria-expanded="false">
                            <i class=" fas fa-file-pdf"></i>


                            <span class="hide-menu">{{ __('documents.all_documents') }} </span>
                        </a>
                        <ul aria-expanded="false" class="collapse first-level">
                            @can('all_documents')
                                <li class="sidebar-item">
                                    <a href="{{ route('documents.index') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('documents.all_documents') }}</span>
                                    </a>
                                </li>
                            @endcan
                            @can('create_documents')
                                <li class="sidebar-item">
                                    <a href="{{ route('documents.create') }}" class="sidebar-link">
                                        <i class="mdi mdi-email"></i>
                                        <span class="hide-menu">{{ __('documents.create_document') }}</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                @endcan
                @can('archive')
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false">
                        <i class="mdi mdi-archive"></i>


                        <span class="hide-menu">{{ __('dashboard.main_archive') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        @can('show_archive')
                        <li class="sidebar-item">
                            <a href="{{ route('documents.main_archive') }}" class="sidebar-link">
                                <i class="mdi mdi-archive"></i>
                                <span class="hide-menu">{{ __('documents.all_documents') }}</span>
                            </a>
                        </li>
                        @endcan
                    </ul>
                </li>
                @endcan
                @can('uploadpdf')
                <li class="sidebar-item">
                    <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                        aria-expanded="false">
                        <i class="mdi mdi-archive"></i>


                        <span class="hide-menu">{{ __('roles.external_files') }} </span>
                    </a>
                    <ul aria-expanded="false" class="collapse first-level">
                        <li class="sidebar-item">
                            <a href="{{ route('documents.external') }}" class="sidebar-link">
                                <i class="mdi mdi-archive"></i>
                                <span class="hide-menu">{{ __('roles.external_files') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
                @endcan


                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('admin.user_management.signature') }}"
                        aria-expanded="false">
                        <i class="mdi mdi-pen"></i>
                        <span class="hide-menu">{{ ($lang == 'ar') ? 'توقيعي الخاص' : "My Signature" }}</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ route('logout') }}"
                        aria-expanded="false">
                        <i class="mdi mdi-directions"></i>
                        <span class="hide-menu">{{ __('login.logout') }}</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
