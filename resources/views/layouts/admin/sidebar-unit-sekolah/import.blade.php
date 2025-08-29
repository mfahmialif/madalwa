                <li class="submenu">
                    <a href="#"><span class="menu-side"><img
                                src="{{ asset('template') }}/assets/img/icons/menu-icon-05.svg" alt=""></span>
                        <span>Import Data</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ request()->RouteIs('admin.laporan-akademik.*') ? 'active' : '' }}"
                                href="{{ route('admin.laporan-akademik.index') }}">Siswa</a></li>
                        <li><a class="{{ request()->RouteIs('admin.import.kelas') ? 'active' : '' }}"
                                href="{{ route('admin.import.kelas') }}">Kelas</a></li>
                    </ul>
                </li>
