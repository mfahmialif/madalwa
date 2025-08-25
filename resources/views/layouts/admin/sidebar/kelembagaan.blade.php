 <li class="submenu">
     <a href="#"><span class="menu-side"><img src="{{ asset('template') }}/assets/img/icons/menu-icon-16.svg"
                 alt=""></span>
         <span> Kelembagaan </span> <span class="menu-arrow"></span></a>
     <ul style="display: none;">
         <li><a class="{{ request()->RouteIs('admin.lembaga.*') ? 'active' : '' }}"
                 href="{{ route('admin.lembaga.index') }}">Profil Lembaga</a></li>
         <li><a class="{{ request()->RouteIs('admin.user.*') ? 'active' : '' }}"
                 href="{{ route('admin.user.index') }}">Data Pengguna</a>
         <li><a class="{{ request()->RouteIs('admin.unit-sekolah.*') ? 'active' : '' }}"
                 href="{{ route('admin.unit-sekolah.index') }}">Data Unit Sekolah</a></li>
         <li><a class="{{ request()->RouteIs('admin.kelas.*') ? 'active' : '' }}"
                 href="{{ route('admin.kelas.index') }}">Data Kelas</a></li>
         <li><a class="{{ request()->RouteIs('admin.kepala-sekolah.*') ? 'active' : '' }}"
                 href="{{ route('admin.kepala-sekolah.index') }}">Kepala Sekolah</a></li>
         <li><a class="{{ request()->RouteIs('admin.guru.*') ? 'active' : '' }}"
                 href="{{ route('admin.guru.index') }}">Data Guru</a></li>
         <li><a class="{{ request()->RouteIs('admin.jurusan.*') ? 'active' : '' }}"
                 href="{{ route('admin.jurusan.index') }}">Data Jurusan</a></li>
     </ul>
 </li>
