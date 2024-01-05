<div id="viewLicenseModal" class="modal fade" role="dialog" data-bs-backdrop="static" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="modal-body">
                <div class="disclaimer_body">
                    <h3>Driving Licence</h3>
                    <div>
                        <img src="{{ $user->driving_license }}" alt="Driving Licence" class="img-fluid">
                    </div>
                    <div class="space-y-8 mt-8">
                        <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                            <!-- Add Admin button -->
                            <button class="btn bg-rose-500 hover:bg-indigo-600 text-white" data-bs-dismiss="modal" type="button">
                                <span class="hidden xs:block ml-2">Close</span>
                            </button>
                            @if (!$user->licence_approved)
                                <button class="btn bg-indigo-500 hover:bg-indigo-600 text-white approveLicence" data-uuid="{{ $user->uuid }}" type="button">
                                    <span class="hidden xs:block ml-2">Approve</span>
                                </button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
