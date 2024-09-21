<div class="col-lg-4 col-md-6">
    <div class="mt-3">
        <form action="{{ url('/user/business') }}" method="post" class="needs-validation" role="form" novalidate>
            @csrf
            <div class="modal fade" id="basicModal" tabindex="-1" style="display: none;" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-body">

                            <div class="row">
                                <div class="col mb-3">
                                    <label for="business_name" class="form-label">Business Name</label>
                                    <span class="bg-red"> *</span>
                                    <input type="text" name="business_name" class="form-control"
                                        placeholder="Please Enter Business Name Here" required />
                                </div>
                                <div class="col mb-3">
                                    <label for="active" class="form-label">Active</label>
                                    <span class="bg-red"> *</span>
                                    <select name="active" class="form-control">
                                        <option value="Y" selected>Yes</option>
                                        <option value="N"> No</option>
                                    </select>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="publish-post">Save</button>
                                <button type="button" class="publish-post bg-ddd"
                                    data-bs-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>
