<div class="c-sidebar-brand">
    <img class="c-sidebar-brand-full" src="{{ url('public/assets/brand/logo.jpg') }}" width="118" height="46" alt="Logo">
    <img class="c-sidebar-brand-minimized" src="{{ url('public/assets/brand/applogo.png') }}" width="118" height="46"
        alt="CoreUI Logo">
</div>
<ul class="c-sidebar-nav">
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('home') }}"><i
                class="cil-speedometer c-sidebar-nav-icon"></i>Dashboard</a>
    </li>

    <!--li class="c-sidebar-nav-title">Mitra Bisnis</li>    
    <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle"
            href="#">
            <i class="cil-house c-sidebar-nav-icon"></i> Client</a>
        <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href=""><i
                        class="cil-list c-sidebar-nav-icon"></i>Client Active</a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href=""><i
                        class="cil-list c-sidebar-nav-icon"></i>Client Waiting</a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href=""><i
                        class="cil-list c-sidebar-nav-icon"></i>Client Category</a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href=""><i
                        class="cil-settings c-sidebar-nav-icon"></i>Client Setting</a>
            </li>
        </ul>
    </li>
    <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle"
            href="#">
            <i class="cil-gem c-sidebar-nav-icon"></i> Module</a>
        <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href=""><i
                        class="cil-list c-sidebar-nav-icon"></i>Module Hotel </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href=""><i
                        class="cil-list c-sidebar-nav-icon"></i>Module Pos UMKM </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href=""><i
                        class="cil-settings c-sidebar-nav-icon"></i>Module Setting</a>
            </li>
        </ul>
    </li>

    <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle"
            href="#">
            <i class="cil-cart c-sidebar-nav-icon"></i> Booking Order</a>
        <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href=""><i
                        class="cil-list c-sidebar-nav-icon"></i>List Booking </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href=""><i
                        class="cil-settings c-sidebar-nav-icon"></i>Payment Setting </a>
            </li>
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href=""><i
                        class="cil-settings c-sidebar-nav-icon"></i>Booking Setting</a>
            </li>
        </ul>
    </li-->

    <li class="c-sidebar-nav-title">Members</li>

    <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle"
            href="#">
            <i class="cil-user c-sidebar-nav-icon"></i> Users</a>
        <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('users.index') }}"><i
                        class="cil-list c-sidebar-nav-icon"></i>User
                    List</a>
            </li>

        </ul>
    </li>

    <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle"
            href="#">
            <i class="cil-ban c-sidebar-nav-icon"></i> Block Users</a>
        <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('block-users') }}"><i
                        class="cil-list c-sidebar-nav-icon"></i>Block User List</a>
            </li>

        </ul>
    </li>

    <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle"
            href="#">
            <i class="cil-people c-sidebar-nav-icon"></i> Groups</a>
        <ul class="c-sidebar-nav-dropdown-items">
            <li class="c-sidebar-nav-item">
                <a class="c-sidebar-nav-link" href="{{ route('group-users') }}"><i
                        class="cil-list c-sidebar-nav-icon"></i>Groups List</a>
            </li>

        </ul>
    </li>
    <li class="c-sidebar-nav-title">General</li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('notification') }}"><i class="cil-bell c-sidebar-nav-icon"></i>Push Notificatin</a>
    </li>
    
    <!--<li class="c-sidebar-nav-item">-->
    <!--    <a class="c-sidebar-nav-link" href="{{ route('admob-list') }}"><i class="fa fa-buysellads c-sidebar-nav-icon"></i>Admob</a>-->
    <!--</li>-->
    
    <li class="c-sidebar-nav-title">Setting</li>

    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ route('setting') }}"><i class="cil-settings c-sidebar-nav-icon"></i>Setting</a>
    </li>

    <li class="c-sidebar-nav-item dropdown-item logout-btn c-sidebar-nav-link">
        <!--<a class="c-sidebar-nav-link" href="#"><i class="cil-account-logout c-sidebar-nav-icon"></i>Logout</a>-->
        <svg class="c-icon mr-2 c-sidebar-nav-item">
                  <use xlink:href="{{ url('/public/icons/sprites/free.svg#cil-account-logout') }}"></use>
                </svg><form action="{{ url('/logout') }}" method="POST"> @csrf <button type="submit" class="btn" id="btn">Logout</button></form>
    </li>
</ul>
<button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent"
    data-class="c-sidebar-minimized"></button>
</div>
