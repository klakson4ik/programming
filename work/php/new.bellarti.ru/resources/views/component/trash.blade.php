@php
    $style = 'style="';
    if (isset($bottom)) {
        $style .= 'bottom: ' . $bottom . ';';
    }
    if (isset($top)) {
        $style .= 'top: ' . $top . ';';
    }
    if (isset($left)) {
        $style .= 'left: ' . $left . ';';
    }
    if (isset($right)) {
        $style .= 'right: ' . $right . ';';
    }
    $style .= 'z-index: -1;"';
@endphp
<div class="c-since-lg c-pos b-trash" {!! $style !!}>
    <img src="{{ $img }}">
</div>
