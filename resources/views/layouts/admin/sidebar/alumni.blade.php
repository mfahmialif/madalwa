 <li class="submenu">
     <a href="#"><span class="menu-side"><img src="{{ asset('template') }}/assets/img/icons/menu-icon-02.svg"
                 alt=""></span>
         <span> Alumni </span> <span class="menu-arrow"></span></a>
     <ul style="display: none;">
         <li><a class="{{ request()->RouteIs('admin.mata-pelajaran.*') ? 'active' : '' }}"
                 href="{{ route('admin.mata-pelajaran.index') }}">Home</a></li>
         <li><a class="{{ request()->RouteIs('admin.mata-pelajaran.*') ? 'active' : '' }}"
                 href="{{ route('admin.mata-pelajaran.index') }}">2024</a></li>
     </ul>
 </li>
