<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form action="{{ url('/attendance') }}" method="post" class="needs-validation" novalidate
            enctype="multipart/form-data">
            @csrf
            <div class="modal fade" id="basicModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="col-12">
                                <label for="user_id" class="form-label">User</label>
                                <select name="user_id" class="form-control" required>
                                    <option value="">Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="check_in_latitude" class="form-label">Check-in Latitude</label>
                                <input type="text" name="check_in_latitude" class="form-control"
                                    placeholder="Enter Check-in Latitude" required />
                            </div>
                            <div class="mb-3">
                                <label for="check_in_longitude" class="form-label">Check-in Longitude</label>
                                <input type="text" name="check_in_longitude" class="form-control"
                                    placeholder="Enter Check-in Longitude" required />
                            </div>
                            <div class="mb-3">
                                <label for="check_in_location" class="form-label">Check-in Location</label>
                                <input type="text" name="check_in_location" class="form-control"
                                    placeholder="Enter Check-in Location" required />
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
