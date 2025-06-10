<form class="b-form" name="{{ $name ?? '' }}" action="{{ $action }}" method="{{ $method ?? 'post' }}" novalidate>
    @csrf
    <div class="{{ $block }}__fields">
        @foreach ($fields as $field)
            <div class="{{ $block }}__field">
                @include('field.' . $field['field'], $field)
            </div>
        @endforeach
    </div>
</form>
