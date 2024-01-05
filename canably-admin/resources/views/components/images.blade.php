@forelse ($images as $key => $image)
    <div class="col-3 px-2 mx-auto">
        <img src="{{ $image['file'] }}" alt="Product image">
        @if ($key != 0)
            <div class="text-center">
                <button class="btn btn-sm btn-info mt-2 featureImage" @if($image['featured']) disabled @endif type="button" data-product="{{ $image['product'] }}" data-uuid="{{ $key }}" data-table="medias">
                    @if ($image['featured'])
                        Featured
                    @else
                        Make Featured
                    @endif
                </button>
            </div>
        @endif
    </div>
@empty
@endforelse
