<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title" key="t-menu">Pages</li>

                <li>
                    <a href="{{ route('backend.home') }}" class="waves-effect">
                        <i class="bx bx-home-circle"></i>
                        <span key="t-calendar">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('backend.version.index') }}" class="waves-effect">
                        <i class="bx bx-revision"></i>
                        <span key="t-calendar">Versions</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('backend.topic.index') }}" class="waves-effect">
                        <i class="bx bx-book"></i>
                        <span key="t-calendar">Topic</span>
                    </a>
                </li>
                
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
<!-- Left Sidebar End -->
