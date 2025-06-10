<form @isset($id) id="{{ $id }}" @endisset class="c-container b-form"
    name="{{ $name ?? 'form' }}" action="{{ $action ?? $_SERVER['REQUEST_URI'] }}" method="{{ $method ?? 'post' }}"
    @if (!$validate) novalidate @endif enctype="multipart/form-data">
    <div class="b-form__fields">
        @foreach ($fields as $field)
            <div class="b-field">
                {!! \TAO::frontend()->renderBlock('fields/' . $field['field'], $field) !!}
                {{-- @include('fields/' . $field['field'], $field) --}}
            </div>
        @endforeach
    </div>
    <input type="submit" value="to">
</form>
