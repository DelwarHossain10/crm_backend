<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form action="{{ url('/service') }}" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
            @csrf
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label">Service Name</label>
                                <span class="bg-red"> *</span>
                                <input type="text" name="name" class="form-control" placeholder="Please Enter Service Name Here" required />
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <span class="bg-red"> *</span>
                                <select name="status" class="form-control">
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="image_path" class="form-label">Image</label>
                                <input type="file" name="image_path" class="form-control"  required />
                            </div>
                        </div>
                        <div class="modal-footer justify-content-end">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
