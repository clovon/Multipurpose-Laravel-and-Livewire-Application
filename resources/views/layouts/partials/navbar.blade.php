<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="{{ auth()->user()->avatar_url }}" id="profileImage" class="img-circle elevation-1" alt="User Image" style="height: 30px; width: 30px;">
                <span class="ml-1" x-ref="username">{{ auth()->user()->name }}</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="{{ route('admin.profile.edit') }}" x-ref="profileLink">Profile</a>
                <a class="dropdown-item" href="{{ route('admin.profile.edit') }}" x-ref="changePasswordLink">Change Password</a>
                <a class="dropdown-item" href="{{ route('admin.settings') }}">Settings</a>
                <div class="dropdown-divider"></div>
                <form method="POST" action="{{ route('logout') }}">
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">Logout</a>
                </form>
            </div>
        </li>
    </ul>
</nav>
