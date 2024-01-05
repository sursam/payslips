<div id="featured_review">
    <h2 class="text-xl leading-snug text-slate-800 font-bold mb-2">Featured Reviews ({{ $productData->reviews->count() }})</h2>
    <ul class="space-y-5 my-6">
        <!-- Review -->
        @include('admin.product.partials.review')
    </ul>
    <!-- Load More -->

</div>
