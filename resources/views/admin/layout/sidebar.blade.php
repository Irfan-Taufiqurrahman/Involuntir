<nav class="sidebar">
    <div class="sidebar-header">
        <a href="#" class="sidebar-brand">
            Noble<span>UI</span>
        </a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main</li>
            <li class="nav-item">
                <a href="/home" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('users') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">User</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('galang-dana') }}" class="nav-link">
                    <i class="link-icon" data-feather="box"></i>
                    <span class="link-title">Galang Dana</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#emails" role="button" aria-expanded="false"
                    aria-controls="emails">
                    <i class="link-icon" data-feather="mail"></i>
                    <span class="link-title">Transaksi</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>
                <div class="collapse" id="emails">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ route('transaksi') }}" class="nav-link">Semua Transaksi</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('fundraiser') }}" class="nav-link">Data Fundraiser</a>
                        </li>

                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
