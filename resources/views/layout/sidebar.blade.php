<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
          <img src="{{ asset('assets/img/logo-rsia.png') }}" alt="Logo Rumah Sakit Ibu dan Anak Kendangsari Merr" style="width: 100%; height:100%;">
        </a>
    </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="{{ (request()->is('admin') || request()->is('dokter') || request()->is('super')) ? 'menu-item active': 'menu-item'}}">
      <a href="{{ url('/') }}" class="menu-link">
        <i class="menu-icon bx bx-grid-alt"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <li class="{{ (request()->is('diagnosa')) ? 'menu-item active': 'menu-item'}}">
      <a href="{{ url('diagnosa') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-first-aid"></i>
        <div data-i18n="Analytics">Jenis Diagnosa</div>
      </a>
    </li>

    <li class="{{ (request()->is('jenistindakan')) ? 'menu-item active': 'menu-item'}}">
      <a href="{{ url('jenistindakan') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-wrench"></i>
        <div data-i18n="Analytics">Jenis Tindakan</div>
      </a>
    </li>

    <li class="{{ (request()->is('dokter')) ? 'menu-item active': 'menu-item'}}">
      <a href={{ url('dokter') }} class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Analytics">Doctor</div>
      </a>
    </li>

    @if (str_contains(Auth::user()->role, 'superadmin') || str_contains(Auth::user()->role, 'admin'))
    <li class="{{ (request()->is('admin')) ? 'menu-item active': 'menu-item'}}">
      <a href="{{ url('admin') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-male"></i>
        <div data-i18n="Analytics">Admin</div>
      </a>
    </li>
    @endif

    @if (str_contains(Auth::user()->role, 'admin'))
    <li class="{{ (request()->is('tindakanPasien')) ? 'menu-item active': 'menu-item'}}">
      <a href="{{ url('tindakanPasien') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-plus-medical"></i>
        <div data-i18n="Analytics">Tindakan Pasien</div>
      </a>
    @endif


    </li>
    @if (str_contains(Auth::user()->role, 'dokter') || str_contains(Auth::user()->role, 'admin'))
    <li class="{{ (request()->is('rekapPendapatan')) ? 'menu-item active': 'menu-item'}}">
      <a href="{{ url('rekapPendapatan') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-data"></i>
        <div data-i18n="Analytics">Rekap Pendapatan</div>
      </a>
    </li>
    @endif

    @if (str_contains(Auth::user()->role, 'superadmin') || str_contains(Auth::user()->role, 'admin'))
    <li class="{{ (request()->is('rekapfeersia')) ? 'menu-item active': 'menu-item'}}">
      <a href="{{ url('rekapfeersia') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-bar-chart-alt-2"></i>
        <div data-i18n="Analytics">Rekap Fee RSIA</div>
      </a>
    </li>
    @endif

    <li class="menu-item">
      <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" class="btn menu-link btn-logout">
              <i class="menu-icon tf-icons bx bx-log-out"></i>
              <div>Logout</div>
          </button>
      </form>
  </li>
  </ul>
</aside>
