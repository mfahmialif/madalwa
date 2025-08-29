 <li class="submenu">
     <a href="#"><span class="menu-side"><img src="{{ asset('template') }}/assets/img/icons/menu-icon-02.svg"
                 alt=""></span>
         <span> Alumni </span> <span class="menu-arrow"></span></a>
     <ul style="display: none;">
         <li><a class="{{ request()->RouteIs('admin.alumni.index') ? 'active' : '' }}"
                 href="{{ route('admin.alumni.index') }}">Home</a></li>
         @php
             $data = \App\Models\TahunPelajaran::all();
         @endphp
         @foreach ($data as $item)
             <li>
                 <a data-alumni="{{ $item->id }}" class="{{ request()->routeIs('admin.alumni.show', 'admin.alumni.show.*') && request()->route('id') == $item->id ? 'active' : '' }}"
                     href="{{ route('admin.alumni.show',['id'=>$item->id]) }}">{{ $item->kode }}</a>
             </li>
         @endforeach
     </ul>
 </li>
