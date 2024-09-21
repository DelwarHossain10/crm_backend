<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form action="{{ url('/category') }}" method="post" class="needs-validation" novalidate enctype="multipart/form-data">
            @csrf
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="service_id" class="form-label">Service</label>
                                <select name="service_id" class="form-control" required>
                                    <option value="" disabled selected>Select Service</option>
                                      @foreach ($services as $service)
                                      <option value="{{ $service->id }}">{{ $service->name }}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="date" class="form-label">Date</label>
                                <input type="datetime-local" name="date" class="form-control" placeholder="Please Enter Date Here" required />
                            </div>
                            <div class="mb-3">
                                <label for="category_name" class="form-label">Category Name</label>
                                <input type="text" name="category_name" class="form-control" placeholder="Please Enter Category Name Here" required />
                            </div>

                            <div class="mb-3">
                                <label for="phone_no" class="form-label">Phone Number</label>
                                <input type="text" name="phone_no" class="form-control" placeholder="Please Enter Phone Number Here" required />
                            </div>
                            <div class="mb-3">
                                <label for="image_path" class="form-label">Image</label>
                                <input type="file" name="image_path" class="form-control" accept="image/*" required />
                            </div>
                            <div class="mb-3">
                                <label for="assign_by" class="form-label">Assign By</label>
                                <select name="assign_by" class="form-control" required>


                                    <option value="" disabled selected>Select Assign By</option>
                                    <!-- Populate options dynamically from database or other source -->
                                    @foreach ($user as $userInfo)
                                    <option value="{{ $userInfo->id }}" >{{ $userInfo->full_name }}</option>
                                @endforeach
                                </select>
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
