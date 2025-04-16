<ul class="nav nav-tabs nav-tabs-block justify-content-center p-0" role="tablist">
    @foreach (App\Models\Language::all() as $language)
        <li class="nav-item flex-fill text-center">
            <a href="{{ route($url, [ $id ?? null,'lang' => $language->slug]) }}"
                class="nav-link {{ $lang  == $language->slug ? 'active' : '' }}"
                id="lang-static-{{ $language->slug }}-tab"
                aria-selected="{{ $lang == $language->slug ? 'true' : 'false' }}">{{ $language->name }}</a>
        </li>
    @endforeach
</ul>