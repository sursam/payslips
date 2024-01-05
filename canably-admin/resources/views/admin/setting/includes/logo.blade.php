<div class="tile">
    <form action="{{ route('admin.settings.update') }}" method="POST" role="form" enctype="multipart/form-data" id="site-logo-form">
        @csrf
        @method('PUT')
        <div>
            <h3 class="o-form-heading">Site Logo</h3>
        </div>
        <div class="tile-body form-body o-custom-form-type">
            
            <div class="form-group o-form-wrapper">
                <div class="form-input-wrapper c-file-input-wrapper">
                    <input class="o-form-element form-control" id="image" type="file" name="site_logo" onchange="loadFile(event,'logoImg')"/>
                    <label for="image">Choose file</label>
                </div>
                <small>Choose new image to replace old image</small>
            </div>

            <div class="form-group o-form-wrapper">
                <div class="o-upload-image-view">
                    <span>
                    @if (getSiteSetting('site_logo') != null)
                        <figure class="mt-0" style="height: auto;">
                            <img src="{{ asset('storage/logo/'.getSiteSetting('site_logo')) }}" id="logoImg" style="width: 80px; height: auto;">
                        </figure>
                    @else
                        <figure class="mt-0" style="height: auto;">
                            <img src="https://via.placeholder.com/80x80?text=Placeholder+Image" id="logoImg" style="width: 80px; height: auto;">
                        </figure>
                    @endif
                    </span>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-primary c-solid-btn" id="btnSave" type="submit">Update Logo</button>
        </div>
    </form>
</div>
@push('scripts')
    <script>
        loadFile = function(event, id) {
            var output = document.getElementById(id);
            output.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@endpush