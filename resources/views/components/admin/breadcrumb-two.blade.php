<div class="bg-body-extra-light">
    <div class="content content-boxed py-3">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-alt">
                @foreach ($breadcrumbs as $breadcrumb)
                    <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}"
                        {{ $loop->last ? 'aria-current="page"' : '' }}>
                        @if (!$loop->last)
                            <a class="link-fx" href="{{ $breadcrumb['url'] ?? 'javascript:void(0)' }}">
                                {{ $breadcrumb['label'] }}
                            </a>
                        @else
                            {{ $breadcrumb['label'] }}
                        @endif
                    </li>
                @endforeach
            </ol>
        </nav>
    </div>
</div>
