<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
        <div class="sidebar-brand-icon">
            <img src="{{ asset((setting('logo')) ? '/storage/'.setting('logo') : 'dist/img/logo/logo2.png') }}">
        </div>
        <div class="sidebar-brand-text mx-3">RuangAdmin</div>
    </a>
    <hr class="sidebar-divider my-0">

    <x-nav-link 
        text="Dashboard" 
        icon="tachometer-alt" 
        url="{{ route('admin.dashboard') }}"
        active="{{ request()->routeIs('admin.dashboard') ? ' active' : '' }}"
    />
    <x-nav-link 
        text="Warung" 
        icon="fas fa-store"
        url="{{ route('admin.warung') }}"
        active="{{ request()->routeIs('admin.warung') ? ' active' : '' }}"
    />
    <x-nav-link 
        text="Pembelian" 
        icon="fas fa-shopping-cart"
        url="{{ route('admin.pembelian') }}"
        active="{{ request()->routeIs('admin.pembelian') ? ' active' : '' }}"
    />
    <x-nav-link 
        text="Barang" 
        icon="fas fa-piggy-bank"
        url="{{ route('admin.warung') }}"
        active="{{ request()->routeIs('admin.warung') ? ' active' : '' }}"
    />
    <x-nav-link 
        text="Kategori" 
        icon="fas fa-tags"
        url="{{ route('admin.warung') }}"
        active="{{ request()->routeIs('admin.warung') ? ' active' : '' }}"
    />
    <x-nav-link 
        text="Penjualan" 
        icon="fas fa-shopping-cart"
        url="{{ route('admin.warung') }}"
        active="{{ request()->routeIs('admin.warung') ? ' active' : '' }}"
    />
    <x-nav-link 
        text="Harga" 
        icon="fas fa-dollar-sign"
        url="{{ route('admin.harga') }}"
        active="{{ request()->routeIs('admin.harga') ? ' active' : '' }}"
    />
    <x-nav-link 
        text="Pembayaran" 
        icon="fas fa-cash-register"
        url="{{ route('admin.warung') }}"
        active="{{ request()->routeIs('admin.warung') ? ' active' : '' }}"
    />
    
    <hr class="sidebar-divider mb-0">

    @can('member-list')
    <x-nav-link 
        text="Member" 
        icon="users" 
        url="{{ route('admin.member') }}"
        active="{{ request()->routeIs('admin.member') ? ' active' : '' }}"
    />
    @endcan

    @can('role-list')
    <x-nav-link 
        text="Roles" 
        icon="th-list" 
        url="{{ route('admin.roles') }}"
        active="{{ request()->routeIs('admin.roles') ? ' active' : '' }}"
    />
    @endcan

    <hr class="sidebar-divider mb-0">
    
    @can('setting-list')
    <x-nav-link 
        text="Settings" 
        icon="cogs" 
        url="{{ route('admin.settings') }}"
        active="{{ request()->routeIs('admin.settings') ? ' active' : '' }}"
    />
    @endcan
</ul>