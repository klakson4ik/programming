<div class="{{ $block }}">
    <h1 class="c-h1">{!! $page->title !!}</h1>
    {!! $renderer->renderBlock('internship/internship-block-1', [
        'page' => $page,
    ]) !!}
    @if (isset($page->block_2_title))
        {!! $renderer->renderBlock('internship/internship-block-2', [
            'page' => $page,
        ]) !!}
    @endif
    @if(isset($page->internship_directions_title))
        {!! $renderer->renderBlock('internship/internship-directions', [
            'page' => $page
        ]) !!}
    @endif
    @if (isset($page->block_3_title))
    {!! $renderer->renderBlock('internship/internship-block-3', [
        'page' => $page,
    ]) !!}
    @endif
    @if (locale() == '')
        {!! $renderer->renderBlock('form/internship', [
            'page' => $page,
        ]) !!}
    @endif
    @if (session('status') && locale() == '')
        {!! $renderer->renderBlock('/partials/popup', [
            'header' => __('pages.mail.internship.subject'),
            'content' => __('form.internship.success'),
        ]) !!}
    @endif
</div>