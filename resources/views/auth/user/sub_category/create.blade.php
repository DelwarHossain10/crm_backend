<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form action="{{ url('/sub_category') }}" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
            @csrf
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Category</label>
                                <select name="category_id" class="form-control" required>
                                    <option value="" disabled selected>Select Category</option>
                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" >{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="service_id" class="form-label">Service</label>
                                <select name="service_id" class="form-control" required>
                                    <option value="" disabled selected>Select Service</option>
                                    @foreach ($services as $service)
                                    <option value="{{ $service->id }}" >{{ $service->name }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="sub_category_name" class="form-label">Sub Category Name</label>
                                <input type="text" name="sub_category_name" class="form-control" placeholder="Please Enter Sub Category Name Here" required />
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Please Enter Address Here" />
                            </div>
                            <div class="mb-3">
                                <label for="image_path" class="form-label">Image</label>
                                <input type="file" name="image_path" class="form-control"  required />
                            </div>
                            <div class="mb-3">
                                <label for="phone_no" class="form-label">Phone Number</label>
                                <input type="text" name="phone_no" class="form-control" placeholder="Please Enter Phone Number Here" />
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
