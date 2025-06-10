<footer class="{{ $block }} c-container">
    <div class="{{ $block->elem('row-top') }}">
        <a class="{{ $block->elem('logo') }}" href="/"><img src="/images/icons/logo.svg" alt="logo"></a>
    </div>
    <div class="{{ $block->elem('row-middle') }}">
        <i class="{{ $block->elem('s-logo') }}">
            <img src="/images/icons/s-footer.svg">
        </i>
        <div class="{{ $block->elem('column-start') }}">
            @if (!empty($info->sociate))
                <div class="{{ $block->elem('sociate') }}">
                    {!! $renderer->renderBlock('common/sociate', [
                        'data' => $info->sociate,
                    ]) !!}
                </div>
            @endif
        </div>
        <div class="{{ $block->elem('column-center') }}">
            @if (!empty($info->menu))
                <div class="{{ $block->elem('menu') }}">
                    @foreach ($info->menu as $item)
                        <a href="{{ href($item['url']) }}">
                            {{ $item['value'] }}
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
        <div class="{{ $block->elem('column-end') }}">
            <div class="{{ $block->elem('info') }}" itemscope itemtype="http://schema.org/Organization">
                <meta itemprop="name" content="Solopharm" />
                @if (!empty($info->address))
                    <a href="{{ $info->address_url }}" class="{{ $block->elem('info-text')->mod('address') }}"
                        itemprop="streetAddress" target="_blank">
                        {{ $info->address }}
                    </a>
                @endif
                @if (!empty($info->phone))
                    <a href="tel:{{ $info->phone }}" class="{{ $block->elem('info-text')->mod('phone') }}"
                        href="tel:{{ $info->phone }}" itemprop="telephone">
                        {{ $info->phone }}
                    </a>
                @endif
                @if (!empty($info->email))
                    <a href="mailto:{{ $info->email }}" class="{{ $block->elem('info-text')->mod('email') }}"
                        href="mailto:{{ $info->email }}" itemprop="email">
                        {{ $info->email }}
                    </a>
                @endif
                @if (app()->getLocale() == 'ru')
                <a href="/about/contacts" class="{{ $block->elem('info-text')}}">
                    {{ __('pages.contacts.title')}}
                </a>
                @endif
            </div>
        </div>
    </div>
    <div class="{{ $block->elem('row-bottom') }}">
        <p class="{{ $block->elem('copyright-rules') }}">
            © {{ date('Y') }}, Solopharm. {{ __('pages.footer.rights') }}
        </p>
        {{-- <div class="{{ $block->elem('copyright-techart') }}">

            </div> --}}

        @if (app()->getLocale() == 'ru')
            <a href="/adverse-reaction-patient" class="{{ $block->elem('adverse-reaction') }}">
                Сообщить о нежелательной реакции
            </a>
            <a href="/policy" class="{{ $block->elem('copyright-policy') }}" target="_blank">
                {{ __('pages.footer.policy') }}
            </a>
        @endif
        {{-- <div class="{{ $block->elem('techart-mark') }}">
            <a class="{{ $block->elem('techart-mark-link')}}" target="_blank" href="https://web.techart.ru">{!! __('pages.footer.techart-web') !!}</a> -
            <a  class="{{ $block->elem('techart-mark-link')}}" target="_blank" href="https://{{ app()->getLocale() != 'ru' ? 'en.' : '' }}techart.ru">{!! __('pages.footer.techart') !!}</a>.
        </div> --}}
    </div>
</footer>
