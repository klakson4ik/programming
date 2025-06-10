<div class="{{ $block }}">
    <div class="{{ $block->elem('img') }} c-section-margin">
        {!! $renderer->renderBlock('main/main-img-block', [
            'title' => $titleImg['titleText'],
            'text1' => $titleImg['text1'],
            'text2' => $titleImg['text2'],
            'img' => $titleImg['img'],
            'youtube' => $titleImg['youtube'],
            'videoFile' => $titleImg['videoFile'] ?? false
        ]) !!}
    </div>
    <div class="{{ $block->elem('about') }} c-section-margin">
        {!! $renderer->renderBlock('main/main-about-block', [
            'block2' => $block2,
            'button' => $renderer->renderBlock('common/button', [
                'type' => 'link',
                'url' => $block2['btnLink'],
                'text' => $block2['btnText'],
                'icon' => 'arrow-long',
            ]),
        ]) !!}
    </div>

    <h2 class="c-h1 c-container">{{ $titles[0] }}</h2>
    <div class="{{ $block->elem('projects') }} c-section-margin">
        {!! $renderer->renderBlock('main/main-projects-block', [
            'id' => 'test1',
            'titleBlock' => $block3[1],
            'icon' => [$block3[0]->label, $block3[1]->label],
            'img' => [$block3[0]->img, $block3[1]->img],
            'title' => [$block3[0]->title, $block3[1]->title],
            'text1' => [$block3[0]->text_1, $block3[1]->text_1],
            'text2' => [$block3[0]->text_2, $block3[1]->text_2],
            'url' => [$block3[0]->url, $block3[1]->url],
        ]) !!}
    </div>

    <div class="{{ $block->elem('direction') }} c-section-margin">
        {!! $renderer->renderBlock('main/main-direction-block', [
            'block4' => $block4,
            'title' => $titles[1],
            'linkUrl' => $linkUrl[1],
            'linkText' => $linkText[1],
            'product' => $product,
        ]) !!}
    </div>

    <div class="{{ $block->elem('slider') }} c-section-margin">
        {!! $renderer->renderBlock('main/main-slider-block', [
            'block5' => $block5,
            'title' => $titles[2],
            'linkUrl' => $linkUrl[2],
            'linkText' => $linkText[2],
        ]) !!}
    </div>




    <div class="b-page__manuf c-section-margin">
        {!! $renderer->renderBlock('main/main-manufacturer-block', [
            'title' => $titles[3],
            'block6' => $block6,
            'text' => $block6Text,
        ]) !!}
    </div>


    @if (app()->getLocale() == 'ru')
        <h2 class="c-container c-h1 b-page__career-title">{!! __('pages.career.title') !!}</h2>

        <p class="c-container b-page__career-desc">{!! __('pages.main.career') !!}</p>

        {!! $renderer->renderBlock('main/main-projects-block', [
            'id' => 'test2',
            'type' => 'work',
            'title_block' => $block3[1],
            'icon' => ['', ''],
            'img' => ['images/development/girl.webp', 'images/development/test7b1.webp'],
            'title' => [$block3[0]->title, $block3[1]->title],
            'text_1' => [$block3[0]->text_1, $block3[1]->text_1],
            'text_2' => [$block3[0]->text_2, $block3[1]->text_2],
        ]) !!}
    @endif

</div>