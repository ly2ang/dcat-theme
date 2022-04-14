@php
    $horizontal = config('admin.layout.horizontal_menu');

    $defaultIcon = config('admin.menu.default_icon', 'feather icon-circle');
@endphp
<aside class="side-scroll">
    @if(! $horizontal)
        <div class="side-navbar-header">
            <a href="{{ admin_url('/') }}" class="side-logo-mini">
                {!! config('admin.logo-mini') !!}
            </a>
        </div>
    @endif
    @foreach($menus as $item)
        @if($builder->visible($item))
            <li class="side-nav-item">
                <a data-id="{{ $item['id'] ?? '' }}"
                   href="{{$tool->getFirstChildrenUrl($item)}}"
                   data-href="{{ $builder->getUrl($tool->getFirstChildrenUrl($item)) }}"
                   class="side-nav-link {!! $builder->isActive($item) ? 'side-nav-active' : '' !!}">
                    <i class="fa fa-fw {{ $item['icon'] ?: $defaultIcon }}"></i>
                    <p>
                        {!! $builder->translate($item['title']) !!}
                    </p>
                </a>
            </li>
        @endif
    @endforeach
</aside>
<aside class="sub-menu">
    @foreach($menus as $item)
        @if($builder->visible($item))
            <div class="sub-menu-item" data-sub-id="{{$item['id']}}"
                 style="display: {{$builder->isActive($item) ? 'block':'none'}}">
                @if(! empty($item['children']))
                    <h4>{!! $builder->translate($item['title']) !!}</h4>
                    @include('canbez.dcat-theme::sub-menu', ['menu' => $item['children']])
                @else
                    @include('canbez.dcat-theme::menu-item', ['item' => $item])
                @endif
            </div>
        @endif
    @endforeach
</aside>
