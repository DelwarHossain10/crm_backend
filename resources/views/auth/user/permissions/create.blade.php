<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form action="{{ url('/permissions') }}" method="post" class="needs-validation" novalidate>
            @csrf
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="name" class="form-label">Permission Name</label>
                                    <span class="bg-red"> *</span>
                                    <input type="text" name="name" class="form-control" placeholder="Please Enter Permission Name Here" required />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-end">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
