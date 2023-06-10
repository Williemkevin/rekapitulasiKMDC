<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
          <img src="{{ asset('assets/img/logo-rsia.png') }}" alt="Logo Rumah Sakit Ibu dan Anak Kendangsari Merr" style="width: 100%; height:100%;">
        </a>
    </div>

  <div class="menu-inner-shadow"></div>

  <ul class="menu-inner py-1">
    <!-- Dashboard -->
    <li class="menu-item">
      <a href="{{ url('/') }}" class="menu-link">
        <i class="menu-icon bx bx-grid-alt"></i>
        <div data-i18n="Analytics">Dashboard</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="{{ url('diagnosa') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-first-aid"></i>
        <div data-i18n="Analytics">Jenis Diagnosa</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="{{ url('jenistindakan') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-wrench"></i>
        <div data-i18n="Analytics">Jenis Tindakan</div>
      </a>
    </li>

    <li class="menu-item">
      <a href={{ url('dokter') }} class="menu-link">
        <i class="menu-icon tf-icons bx bx-user"></i>
        <div data-i18n="Analytics">Doctor</div>
      </a>
    </li>

    <li class="menu-item">
      <a href="{{ url('tindakanPasien') }}" class="menu-link">
        <i class="menu-icon tf-icons bx bx-plus-medical"></i>
        <div data-i18n="Analytics">Tindakan Pasien</div>
      </a>

    </li>

    <li class="menu-item">
      <a href="index.html" class="menu-link">
        <i class="menu-icon tf-icons bx bx-log-out"></i>
        <div data-i18n="Analytics" style="color: red">Log Out</div>
      </a>
    </li>
  </ul>
</aside>
