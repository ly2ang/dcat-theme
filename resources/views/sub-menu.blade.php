@php
    $horizontal = config('admin.layout.horizontal_menu');

    $defaultIcon = config('admin.menu.default_icon', 'feather icon-circle');
@endphp


@foreach($menu as $item)
    @if(! empty($item['children']))
        <li class="{{ $horizontal ? 'dropdown' : 'has-treeview' }} dropdown-submenu sub-item nav-item {{ $builder->isActive($item) ? 'menu-open' : '' }}">
            <a @if(mb_strpos($item['uri'], '://') !== false) target="_blank" @endif
            href="#"
               class="sub-link nav-link  {{ $builder->isActive($item) ? ($horizontal ? 'sub-active' : '') : '' }}
               {{ $horizontal ? 'dropdown-toggle' : '' }}">
                <p>
                    <i class="fa fa-fw {{ $item['icon'] ?: $defaultIcon }}"></i>
                    <span>
                        {!! $builder->translate($item['title']) !!}
                    </span>
                </p>
                @if(! $horizontal)
                    <i class="fa fa-angle-left"></i>
                @endif
            </a>
            <ul class="nav {{ $horizontal ? 'dropdown-menu' : 'nav-treeview' }}">
                @foreach($item['children'] as $item)
                    @if(! empty($item['children']))
                        @include('canbez.dcat-theme::sub-menu', ['menu' => $item['children']])
                    @else
                        @include('canbez.dcat-theme::menu-item', ['item' => $item])
                    @endif
                @endforeach
            </ul>
        </li>
    @else
        @include('canbez.dcat-theme::menu-item', ['item' => $item])
    @endif
@endforeach


