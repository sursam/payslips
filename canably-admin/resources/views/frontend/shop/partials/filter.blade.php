@php
$checked= request()->type ?? request()->slug;
$param= request()->value ?? '';
@endphp
@foreach ($datas as $key=>$data )
    <div class="shop-by-row">
        <h2>Shop By {{ ucfirst($key) }}</h2>
        @foreach ($data as $value)
            <div class="form-check">
                <input class="form-check-input filterBy" name="{{ $key.'[]' }}" type="checkbox" value="{{ $value->slug }}"  id="{{ $key.'-'.$value->uuid }}" @if($checked == $value->slug || $param== $value->slug ) checked @endif>
                <label class="form-check-label" for="{{ $key.'-'.$value->uuid }}">
                    {{ $value->name }}
                </label>
            </div>
        @endforeach

    </div>
@endforeach

