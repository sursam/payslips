@forelse ($addresses as $address)
    <div class="col-lg-4 col-sm-4 col-12">
        <div class="addrs-book-box">
            <h3 class="text-capitalize">
                {{ $address->type }}
                @if ($address->is_default)
                    <span>Default Address</span>
                @endif
            </h3>
            <p>{{ $address->name ?? auth()->user()->full_name }}</p>
            <p>{{ $address->full_address['address_line_one'] }}</p>
            <div class="edit-section">
                <ul>
                    <li><a href="javascript:void(0)" class="editAddress" data-uuid="{{ $address->uuid }}">Edit</a></li>
                    @if (!$address->is_default)
                        <li><a href="javascript:void(0)" class="setDefaultAddress" data-uuid="{{ $address->uuid }}" data-table="addresses" data-default="1">Set As Default</a></li>
                        <li><a href="javascript:void(0)" class="removeAddress" data-uuid="{{ $address->uuid }}" data-table="addresses">Remove</a></li>
                    @endif


                </ul>
            </div>
        </div>
    </div>
@empty
@endforelse

<div class="col-lg-4 col-sm-4 col-12">
    <div class="addrs-book-box">
        <div class="addrs-book-box-icon"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#add-modal"><i class="fa fa-plus" aria-hidden="true"></i></a>
        </div>
        <h4>Add New Address</h4>
    </div>
</div>


