                <li class="submenu">
                    <a href="#"><span class="menu-side"><img
                                src="{{ asset('template') }}/assets/img/icons/menu-icon-05.svg" alt=""></span>
                        <span>Import Data</span> <span class="menu-arrow"></span></a>
                    <ul style="display: none;">
                        <li><a class="{{ request()->RouteIs('admin.import.siswa.show') ? 'active' : '' }}"
                                href="{{ route('admin.import.siswa.show') }}">Siswa</a></li>
                        <li><a class="{{ request()->RouteIs('admin.import.kelas.show') ? 'active' : '' }}"
                                href="{{ route('admin.import.kelas.show') }}">Kelas</a></li>
                        <li><a class="{{ request()->RouteIs('admin.import.mata-pelajaran.show') ? 'active' : '' }}"
                                href="{{ route('admin.import.mata-pelajaran.show') }}">Mata Pelajaran</a></li>
                        <li><a class="{{ request()->RouteIs('admin.import.kurikulum.show') ? 'active' : '' }}"
                                href="{{ route('admin.import.kurikulum.show') }}">Kurikulum</a></li>
                    </ul>
                </li>
