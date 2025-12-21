<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>

<div class="sidebar-menu" id="sidebarMenu">
    <div class="sidebar-header">
        <a href="{{ route('home') }}" class="sidebar-logo">FandhFood</a>
        <button class="sidebar-close" onclick="closeSidebar()">
            <i class="las la-times"></i>
        </button>
    </div>

    <nav class="sidebar-nav">
        <a href="{{ route('home') }}" class="sidebar-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <i class="las la-home"></i>
            <span>Ana Sayfa</span>
        </a>

        @auth
            <a href="{{ route('profile') }}" class="sidebar-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                <i class="las la-user"></i>
                <span>Profilim</span>
            </a>

            <a href="{{ route('profile') }}#orders" class="sidebar-link">
                <i class="las la-shopping-bag"></i>
                <span>Siparişlerim</span>
            </a>

            @if(auth()->user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="sidebar-link"
                    style="background: linear-gradient(135deg, rgba(255, 126, 32, 0.2) 0%, rgba(232, 106, 10, 0.2) 100%); border: 1px solid var(--main-color);">
                    <i class="las la-cog"></i>
                    <span>Admin Panel</span>
                </a>
            @endif

            <div class="sidebar-divider"></div>

            <div class="sidebar-user">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <span class="sidebar-user-name">{{ auth()->user()->name }}</span>
                    <span class="sidebar-user-email">{{ auth()->user()->email }}</span>
                </div>
            </div>

            <div class="sidebar-divider"></div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link sidebar-logout">
                    <i class="las la-sign-out-alt"></i>
                    <span>Çıkış Yap</span>
                </button>
            </form>
        @else
            <div class="sidebar-divider"></div>

            <a href="{{ route('login') }}" class="sidebar-link">
                <i class="las la-sign-in-alt"></i>
                <span>Giriş Yap</span>
            </a>

            <a href="{{ route('register') }}" class="sidebar-link">
                <i class="las la-user-plus"></i>
                <span>Kayıt Ol</span>
            </a>
        @endauth
    </nav>

    <div class="sidebar-footer">
        <div class="sidebar-theme-toggle" onclick="toggleDarkMode(); closeSidebar();">
            <i class="las la-moon"></i>
            <span>Karanlık Mod</span>
        </div>
    </div>
</div>