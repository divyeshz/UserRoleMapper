<nav class="bottom-navbar">
    <div class="container">
        <ul class="nav page-navigation">
            <li class="nav-item @if (Request::path() == 'dashboard') active @endif">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item @if (Request::path() == 'userEditForm') active @endif">
                <a href="{{ route('user.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="users"></i>
                    <span class="menu-title">Users</span>
                    <i class="link-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link @if (Request::path() == 'userList') active @endif"
                                href="{{ route('user.list') }}">List User</a></li>
                        <li class="nav-item"><a class="nav-link @if (Request::path() == 'userAddForm') active @endif"
                                href="{{ route('user.addForm') }}">Add User</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item @if (Request::path() == 'roleEditForm') active @endif">
                <a href="{{ route('role.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="at-sign"></i>
                    <span class="menu-title">Role</span>
                    <i class="link-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link @if (Request::path() == 'roleList') active @endif"
                                href="{{ route('role.list') }}">List Role</a></li>
                        <li class="nav-item"><a class="nav-link @if (Request::path() == 'roleAddForm') active @endif"
                                href="{{ route('role.addForm') }}">Add Role</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item @if (Request::path() == 'permissionEditForm') active @endif">
                <a href="{{ route('permission.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="unlock"></i>
                    <span class="menu-title">Permission</span>
                    <i class="link-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link @if (Request::path() == 'permissionList') active @endif"
                                href="{{ route('permission.list') }}">List Permission</a></li>
                        <li class="nav-item"><a class="nav-link @if (Request::path() == 'permissionAddForm') active @endif"
                                href="{{ route('permission.addForm') }}">Add Permission</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item @if (Request::path() == 'moduleEditForm') active @endif">
                <a href="{{ route('module.list') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="menu-title">Module</span>
                    <i class="link-arrow"></i>
                </a>
                <div class="submenu">
                    <ul class="submenu-item">
                        <li class="nav-item"><a class="nav-link @if (Request::path() == 'permissionList') active @endif"
                                href="{{ route('module.list') }}">List Module</a></li>
                        <li class="nav-item"><a class="nav-link @if (Request::path() == 'permissionAddForm') active @endif"
                                href="{{ route('module.addForm') }}">Add Module</a></li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
