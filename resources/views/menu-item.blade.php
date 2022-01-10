<li class="nav-item">
    <a data-id="{{ $item['id'] ?? '' }}"
       @if(mb_strpos($item['uri'], '://') !== false) target="_blank"
       @endif
       href="{{ $builder->getUrl($item['uri']) }}"
       class="sub-link nav-link  {!! $builder->isActive($item) ? 'sub-active' : '' !!}">
        <p>
            <i class="fa fa-fw {{ $item['icon'] ?: $defaultIcon }}"></i>
            <span>
                {!! $builder->translate($item['title']) !!}
            </span>
        </p>
    </a>
</li>
