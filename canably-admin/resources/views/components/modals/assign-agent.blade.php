<div class="modal fade" id="assignAgentModal" tabindex="-1" aria-labelledby="assignAgentModal" aria-hidden="true"
    data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-b border-slate-200">
                <div class="d-flex col-12">
                    <div class="font-semibold text-slate-800 col-8">Assign Delivery Agent</div>
                    <div class="col-4 text-right">
                        <button class="text-slate-400 hover:text-slate-500" data-bs-dismiss="modal">
                            <div class="sr-only">Close</div>
                            <svg class="w-4 h-4 fill-current">
                                <path
                                    d="M7.95 6.536l4.242-4.243a1 1 0 111.415 1.414L9.364 7.95l4.243 4.242a1 1 0 11-1.415 1.415L7.95 9.364l-4.243 4.243a1 1 0 01-1.414-1.415L6.536 7.95 2.293 3.707a1 1 0 011.414-1.414L7.95 6.536z" />
                            </svg>
                        </button>
                    </div>

                </div>
            </div>
            <form action="{{ route('admin.inventory.delivery.assign.agent',$order->uuid) }}" method="POST" enctype="multipart/form-data" id="agentAssignForm" class="formSubmit">
                <div class="modal-body">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium mb-1" for="name">Select an agent<span class="text-rose-500">*</span>
                            </label>
                            <select name="agent" id="agent" class="form-input w-full px-2 py-1" required>
                                <option value="">Select an delivery agent</option>
                                @foreach ($agents as $agent)
                                    <option value="{{ $agent->uuid }}">{{ $agent->full_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1" for="feedback">Comment<span
                                    class="text-rose-500">*</span></label>
                            <textarea id="comment" class="form-textarea w-full px-2 py-1" rows="4" name="comment" required>{{ $detailedStatus['packed']['comment'] }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="flex flex-wrap justify-end space-x-2">
                        <button type="reset" class="btn-sm border-slate-200 hover:border-slate-300 text-slate-600"
                            data-bs-dismiss="modal">Close</button>
                        <button class="btn-sm bg-indigo-500 hover:bg-indigo-600 text-white" type="submit">Assign</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
