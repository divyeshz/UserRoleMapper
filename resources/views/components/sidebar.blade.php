<nav class="bottom-navbar">
    <div class="container">
        <ul class="nav page-navigation">
            <li class="nav-item @if(Request::path() == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item @if(Request::path() == 'userList') active @endif">
                <a href="{{ route('user.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="menu-title">Users</span>
                    <i class="link-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link @if(Request::path() == 'userList') active @endif" href="{{ route('user.list') }}">List User</a></li>
                        <li class="nav-item"><a class="nav-link @if(Request::path() == 'userAddForm') active @endif" href="{{ route('user.addForm') }}">Add User</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item @if(Request::path() == 'roleList') active @endif">
                <a href="{{ route('user.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="at-sign"></i>
                    <span class="menu-title">Users</span>
                    <i class="link-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link @if(Request::path() == 'roleList') active @endif" href="{{ route('role.list') }}">List User</a></li>
                        <li class="nav-item"><a class="nav-link @if(Request::path() == 'roleAddForm') active @endif" href="{{ route('role.addForm') }}">Add User</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
