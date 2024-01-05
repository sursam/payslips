<div class="shop-by-row">
    <h2>Shop By Type</h2>

    <label>
        <input type="radio" name="priceRange" class="priceRange" value="0-10">
    <h6>Under $10.00 </h6>
    </label>

    <label>
        <input type="radio" name="priceRange" class="priceRange" value="10-50">
    <h6>$10.00 - $50.00</h6>
    </label>

    <label>
        <input type="radio" name="priceRange" class="priceRange" value="100-500">
    <h6>$100.00 - $500.00</h6>
    </label>
    {{--  <p><label for="customRange1" class="form-label"></label>
        <input type="range" class="form-range" id="customRange1">
    </p>  --}}

    <div class="price-range-slider">
        <div class="range-slide-bar">
        <p class="range-value">
          <input type="text" id="amountmin" name="sliderPrice[min]" value="$1" readonly>
          <input type="text" id="amountmax"  value="$1000" name="sliderPrice[max]" readonly>
        </p>
        <div id="slider-range" class="range-bar"></div>
        </div>

        <button type="button" class="apply">Go</button>

      </div>
</div>



